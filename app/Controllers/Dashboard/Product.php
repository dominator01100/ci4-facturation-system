<?php namespace App\Controllers\Dashboard;
use App\Models\ProductModel;
use App\Models\ProductsControlModel;
use App\Controllers\BaseController;
use \CodeIgniter\Exceptions\PageNotFoundException;
use \CodeIgniter\API\ResponseTrait;
use Dompdf\Dompdf;

class Product extends BaseController {

    use ResponseTrait;

    public function index() {
        $product = new ProductModel();
        $data = ['products' => $product->asObject()->paginate(10), 'pager' => $product->pager];
        $this->_loadDefaultView('Listado de productos', $data, 'index');
    }

    public function new () {
        $product = new ProductModel();
        $validation = \Config\Services::validation();
        $this->_loadDefaultView('Crear producto', ['validation' => $validation, 'product' => new ProductModel(), 'products' => $product->asObject()->findAll() ], 'new');
    }

    public function create() {
        $product = new ProductModel();
        if ($this->validate('products')) {
            $id = $product->insert([
                'name' => $this->request->getPost('name'),
                'code' => $this->request->getPost('code'), 
                'description' => $this->request->getPost('description'), 
                'entry' => $this->request->getPost('entry'), 
                'exit' => $this->request->getPost('exit'), 
                'stock' => $this->request->getPost('stock'), 
                'price' => $this->request->getPost('price'), 
            ]);
            return redirect()->to("/dashboard/product/$id/edit")->with('message', 'Producto creada con éxito.');
        } else {
            session()->setFlashdata(['validation' => $this->validator]);
        }
        return redirect()->back()->withInput();
    }

    public function edit($id = null) {
        $product = new ProductModel();
        if ($product->find($id) == null) {
            throw PageNotFoundException::forPageNotFound();
        }
        $validation = \Config\Services::validation();
        $this->_loadDefaultView('Actualizar producto', ['validation' => $validation, 'product' => $product->asObject()->find($id), ], 'edit');
    }

    public function update($id = null) {
        $product = new ProductModel();
        if ($product->find($id) == null) {
            throw PageNotFoundException::forPageNotFound();
        }
        if ($this->validate('products')) {
            $product->update($id, [
                'name' => $this->request->getPost('name'),
                'code' => $this->request->getPost('code'), 
                'description' => $this->request->getPost('description'), 
                'entry' => $this->request->getPost('entry'), 
                'exit' => $this->request->getPost('exit'), 
                'stock' => $this->request->getPost('stock'), 
                'price' => $this->request->getPost('price'), 
            ]);
            return redirect()->to('/dashboard/product')->with('message', 'Producto editado con éxito.');
        } else {
            session()->setFlashdata(['validation' => $this->validator]);
        }
        return redirect()->back()->withInput();
    }

    public function delete($id = null) {
        $product = new ProductModel();
        if ($product->find($id) == null) {
            throw PageNotFoundException::forPageNotFound();
        }
        $product->delete($id);
        return redirect()->to('/dashboard/product')->with('message', 'Producto eliminado con éxito.');
    }

    public function addStock($id, $entry) {
        // Validar
        $validation = \Config\Services::validation();

        if (!$validation->check($entry, 'required|is_natural_no_zero')) {
            return $this->failValidationErrors("Cantidad no es valida.");
        }

        // Aumentar el stock
        $productModel = new ProductModel();
        $productsControlModel = new ProductsControlModel();
        $product = $productModel->asObject()->find($id);

        if ($product == null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $product->stock += $entry;
        $product->entry = $entry;

        $productModel->update($id, [
            'entry' => $product->entry,
            'stock' => $product->stock,
        ]);

        $productsControlModel->insert([
            'product_id' => $id,
            'count' => $entry,
            'type' => 'entry',
        ]);

        return $this->respondUpdated([$product]);
        // return $this->respondDeleted(['stock' => 50]);
        // return $this->failForbidden();
    }

    public function exitStock($id, $exit) {
        // Validar
        $validation = \Config\Services::validation();

        if (!$validation->check($exit, 'required|is_natural_no_zero')) {
            return $this->failValidationErrors("Cantidad no es valida.");
        }

        $productModel = new ProductModel();
        $productsControlModel = new ProductsControlModel();
        $product = $productModel->asObject()->find($id);

        if ($product == null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $product->stock -= $exit;
        $product->exit = $exit;

        $productModel->update($id, [
            'exit' => $product->exit,
            'stock' => $product->stock,
        ]);

        $productsControlModel->insert([
            'product_id' => $id,
            'count' => $exit,
            'type' => 'exit',
        ]);

        return $this->respondUpdated([$product]);
    }

    public function demoPDF() {
        $dompdf = new Dompdf();
        $dompdf->loadHtml('<h1>hello world</h1><br><p>Otro contenido</p>');
        $dompdf->setPaper('A4', 'portraint');
        $dompdf->render();
        $dompdf->stream();
    }
    
    private function _loadDefaultView($title, $data, $view) {
        $dataHeader = ['title' => $title];
        echo view("dashboard/templates/header", $dataHeader);
        echo view("dashboard/product/$view", $data);
        echo view("dashboard/templates/footer");
    }
}