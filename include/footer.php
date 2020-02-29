<!-- FOOTER START -->
<footer class="bg-dark w-100">
  <div class="container">
    <div class="row">
      <div class="col-12 d-flex justify-content-center">
      <?php foreach($socMedia as $sm): ?>
        <div class="m-3">
          <a target="blank" href="<?=$sm["href"]?>"> <i class="fab <?=$sm["logo"]?> text-light font-25"></i> </a> 
        </div>
        <?php endforeach ?>
      </div>
    </div>
  </div>
  <div class="container-fluid border-top">
    <div class="row">
      <div class="col-12 d-flex justify-content-center">
        <p class="text-center text-light mt-3">© 2020 Copyright: Nikola Ciganovic</p>
      </div>
    </div>
  </div>
</footer>
<!-- FOOTER END -->