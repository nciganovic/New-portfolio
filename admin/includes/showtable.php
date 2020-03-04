<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 id="table-name" class="m-0 font-weight-bold text-primary"><?= strtoupper($table) ?></h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <?php foreach($allColumns as $a): ?>
              <th><?=$a[0]?></th>
            <?php endforeach ?>
            <td>Edit</td>
            <td>Delete</td>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <?php foreach($allColumns as $a): ?>
              <th><?=$a[0]?></th>
            <?php endforeach ?>
            <td>Edit</td>
            <td>Delete</td>
          </tr>
        </tfoot>
        <tbody>
          <?php for($i = 0; $i < count($tableInfo); $i++): ?>
          <tr>
            <?php for($y = 0; $y < count($tableInfo[$i]) / 2; $y++): ?>
            <td><?= $tableInfo[$i][$y] ?></td>
            <?php endfor ?>
            <td><a href='editrow.php?id=<?=$tableInfo[$i][0]?>&table=<?=$table?>' class="btn btn-warning">Edit</a></td>
            <td><a href='#' data="<?=$tableInfo[$i][0]?>" class="btn btn-danger">Delete</a></td>
          </tr>
          <?php endfor ?>
        </tbody>
      </table>
    </div>
    <div class="col-12">
        <a href='createrow.php?table=<?=$table?>' class="btn btn-success">Create</a>
    </div>
  </div>
</div>