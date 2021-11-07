<?= view("dashboard/partials/_form-error"); ?>
<form action="/dashboard/tag/create" method="post">
<?= view("dashboard/tag/_form",['textButton' => 'Guardar','created' => true]); ?>
</form>