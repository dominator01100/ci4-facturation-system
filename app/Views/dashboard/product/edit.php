<?= view("dashboard/partials/_form-error"); ?>
<form action="/dashboard/product/update/<?= $product->id ?>" method="post">
<?= view("dashboard/product/_form",['textButton' => 'Actualizar','created' => false]); ?>
</form>