<?php namespace App\Controllers\Dashboard;
use App\Models\CategoryModel;
use App\Controllers\BaseController;
use \CodeIgniter\Exceptions\PageNotFoundException;

class Category extends BaseController {

    public function index() {
        $category = new CategoryModel();
        $data = ['categories' => $category->asObject()->paginate(10), 'pager' => $category->pager];
        $this->_loadDefaultView('Listado de categorías', $data, 'index');
    }

    public function new () {
        $category = new CategoryModel();
        $validation = \Config\Services::validation();
        $this->_loadDefaultView('Crear categoría', ['validation' => $validation, 'category' => new CategoryModel(), 'categories' => $category->asObject()->findAll() ], 'new');
    }

    public function create() {
        $category = new CategoryModel();
        if ($this->validate('categories')) {
            $id = $category->insert(['name' => $this->request->getPost('name'), ]);
            return redirect()->to("/dashboard/category/$id/edit")->with('message', 'Categoría creada con éxito.');
        } else {
            session()->setFlashdata(['validation' => $this->validator]);
        }
        return redirect()->back()->withInput();
    }

    public function edit($id = null) {
        $category = new CategoryModel();
        if ($category->find($id) == null) {
            throw PageNotFoundException::forPageNotFound();
        }
        $validation = \Config\Services::validation();
        $this->_loadDefaultView('Actualizar categoría', ['validation' => $validation, 'category' => $category->asObject()->find($id), ], 'edit');
    }

    public function update($id = null) {
        $category = new CategoryModel();
        if ($category->find($id) == null) {
            throw PageNotFoundException::forPageNotFound();
        }
        if ($this->validate('categories')) {
            $category->update($id, ['name' => $this->request->getPost('name'), ]);
            return redirect()->to('/dashboard/category')->with('message', 'Categoría editada con éxito.');
        } else {
            session()->setFlashdata(['validation' => $this->validator]);
        }
        return redirect()->back()->withInput();
    }

    public function delete($id = null) {
        $category = new CategoryModel();
        if ($category->find($id) == null) {
            throw PageNotFoundException::forPageNotFound();
        }
        $category->delete($id);
        return redirect()->to('/dashboard/category')->with('message', 'Categoría eliminada con éxito.');
    }
    
    private function _loadDefaultView($title, $data, $view) {
        $dataHeader = ['title' => $title];
        echo view("dashboard/templates/header", $dataHeader);
        echo view("dashboard/category/$view", $data);
        echo view("dashboard/templates/footer");
    }
}