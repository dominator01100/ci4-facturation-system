<?= view("dashboard/partials/_form-error"); ?>
<form action="/dashboard/category/create" method="post">
<?= view("dashboard/category/_form",['textButton' => 'Guardar','created' => true]); ?>
</form>