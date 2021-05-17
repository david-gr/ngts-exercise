<table style="border: 1px solid black; text-align: center; border-spacing: 25px;">
    <tr>
        <th>Origen</th>
        <th>Destino</th>
        <th>Coste</th>
        <th>Ruta</th>
    </tr>
    <?php foreach($paths as $path) :?>
        <tr>
            <td><?= $path['origin'] ?></td>
            <td><?= $path['destination'] ?></td>
            <td><?= $path['cost'] ?></td>
            <td><?= implode(' - ', $path['path']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>