<?= view("dashboard/partials/_form-error"); ?>
<form action="/dashboard/product/create" method="post">
<?= view("dashboard/product/_form",['textButton' => 'Guardar','created' => true]); ?>
</form>