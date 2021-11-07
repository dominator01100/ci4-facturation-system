<a href="/dashboard/product/new"> Crear</a>

<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Código</th>
            <th>Entradas</th>
            <th>Salidas</th>
            <th>Stock</th>
            <th>Precio</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($products as $key => $p): ?>
            <tr>
                <td><?= $p->id ?></td>
                <td><?= $p->name ?></td>
                <td><?= $p->code ?></td>
                <td><input type="number" data-id="<?= $p->id?>" name="entry" class="entry" value="<?= $p->entry?>"></td>
                <td><input type="number" data-id="<?= $p->id?>" name="exit" class="exit" value="<?= $p->exit?>"></td>
                <td><?= $p->stock ?></td>
                <td><?= $p->price ?></td>
                <td>

                    <form action="/dashboard/product/delete/<?= $p->id ?>" method="post">
                        <button>Eliminar</button>
                    </form>

                    <a href="/dashboard/product/<?= $p->id ?>/edit">Editar</a>

                </td>
            </tr>
        <?php endforeach?>

    </tbody>
</table>

<?= $pager->links() ?>

<script>
    // Entrada de stock
    entries = document.querySelectorAll('.entry');

    entries.forEach(function(entry) {
        entry.addEventListener('keyup', function(event) {
            id = entry.getAttribute('data-id');
            if (event.keyCode === 13) {
                fetch(`/dashboard/product/add-stock/${id}/${entry.value}`, {
                    method: 'POST'
                }).then((res) => {
                    switch(res.status) {
                        case 400: // Problema con la respuesta
                            throw new Error("Error de validación.");
                            break;
                    }
                    return res.json(); // Respuesta OK
                })
                .then((res) => {
                    console.log(res);
                })
                .catch((res) => {
                    console.error(res);
                })
            }
        });
    });

    // Salida de stock
    exits = document.querySelectorAll('.exit');

    exits.forEach(function(exit) {
        exit.addEventListener('keyup', function(event) {
            id = exit.getAttribute('data-id');
            if (event.keyCode === 13) {
                fetch(`/dashboard/product/exit-stock/${id}/${exit.value}`, {
                    method: 'POST'
                }).then((res) => {
                    switch(res.status) {
                        case 400: // Problema con la respuesta
                            throw new Error("Error de validación.");
                            break;
                    }
                    return res.json(); // Respuesta OK
                })
                .then((res) => {
                    console.log(res);
                })
                .catch((res) => {
                    console.error(res);
                })
            }
        });
    });
</script>

<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type="number"] {
        -moz-appearance: textfield;
    }
</style>