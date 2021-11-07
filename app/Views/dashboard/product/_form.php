<script src="https://cdn.ckeditor.com/ckeditor5/31.0.0/classic/ckeditor.js"></script>
    
    <label for="name">Nombre</label>
    <input type="text" id="name" name="name" value="<?=old('name', $product->name)?>"/>

    <label for="code">Código</label>
    <input type="text" id="code" name="code" value="<?=old('code', $product->code)?>"/>

    <label for="description">Descripción</label>
    <textarea name="description" id="description"><?=old('description', $product->description)?></textarea>

    <label for="entry">Entrada</label>
    <input type="number" id="entry" name="entry" value="<?=old('entry', $product->entry)?>"/>

    <label for="exit">Salida</label>
    <input type="number" id="exit" name="exit" value="<?=old('exit', $product->exit)?>"/>

    <label for="stock">Stock</label>
    <input type="number" id="stock" name="stock" value="<?=old('stock', $product->stock)?>"/>

    <label for="price">Precio</label>
    <input type="text" id="price" name="price" value="<?=old('price', $product->price)?>"/>

    <button type="submit"><?=$textButton?></button>

<script>
    ClassicEditor.create(document.querySelector("#description"))
</script>