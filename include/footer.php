<!-- FOOTER START -->
<footer class="theme-dark w-100">
  <div class="container pt-5">
    <div class="row">
      <div class="col-12 d-flex justify-content-center">
      <?php foreach($socMedia as $sm): ?>
        <div class="m-3">
          <a target="blank" href="<?=$sm["href"]?>"> <i class="fab txt-theme-3 <?=$sm["logo"]?> font-25"></i> </a> 
        </div>
        <?php endforeach ?>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row pb-5">
      <div class="col-12 d-flex justify-content-center">
        <p class="text-center mt-3 raleway-p txt-theme-3">© 2020 Copyright: Nikola Ciganovic. All rights reserved.</p>
      </div>
    </div>
  </div>
</footer>
<!-- FOOTER END -->