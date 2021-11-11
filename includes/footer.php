<?php
#$date = new DateTime( "now", new DateTimeZone( TIMEZONE ) );
?>

<!-- Footer -->
<footer class="page-footer font-small" style="background: rgb(5, 99, 161);">

    <!-- Footer Links -->
    <div class="container text-center text-md-left">

      <!-- Grid row -->
      <div class="row">

        <!-- Grid column -->
        <div class="col-lg-5 col-md-5 mx-auto">

          <!-- Links -->
          <h5 class="font-weight-bold text-uppercase mt-3 mb-4">Contact Information</h5>

          <ul class="list-unstyled">
            <li>
              <a href="#!"><i class="fa fa-phone"></i> <i style="margin-left:5px; font-weight:bolder;padding:3px; "><?php echo $set['phone']; ?></i></a>
            </li>
            <li>
            <a href="#!"><i class="fa fa-envelope"></i> <i style="margin-left:5px; font-weight:bolder;padding:3px;"><?php echo $set['siteEmail']; ?></i></a>
            </li>
            <li>
            <a href="#!"><i class="fa fa-map-marker"></i> <i style="margin-left:5px; font-weight:bolder; padding:3px; text-align:left;"><?php echo $set['address']; ?></i></a>
            </li>
            <li>
            <a href="#!"><i class="fa fa-location-arrow"></i> <i style="margin-left:5px; font-weight:bolder; padding:3px; text-align:left;"><?php echo $set['location']; ?></i></a>
            </li>
          </ul>

        </div>
        <!-- Grid column -->

       

        <hr class="clearfix w-100 d-md-none">

        <!-- Grid column -->
        <div class="col-md-4 mx-auto">

          <!-- Links -->
          <h5 class="font-weight-bold text-uppercase mt-3 mb-4">Services</h5>

          <ul class="list-unstyled">
            <li>
              <a href="#!" style="font-weight:bolder; padding:3px; text-align:left;">Bidding</a>
            </li>
           
            
          </ul>

        </div>
        <!-- Grid column -->

        <hr class="clearfix w-100 d-md-none">

        <!-- Grid column -->
        <div class="col-md-3 mx-auto">

          <!-- Links -->
          <h5 class="font-weight-bold text-uppercase mt-3 mb-4">Links</h5>

          <ul class="list-unstyled">
            <li>
              <a href="#about-us">About Us</a>
            </li>
            <li>
              <a href="#contact-us">Contact Us</a>
            </li>
            <li>
              <a href="#faq">faq</a>
            </li>
            <li>
              <a href="#terms-conditions">Terms & Conditions</a>
            </li>
            <li>
              <a href="#privacy">Privacy</a>
            </li>
          </ul>

        </div>
        <!-- Grid column -->

      </div>
      <!-- Grid row -->

    </div>
    <!-- Footer Links -->

    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">Copyright &copy; <?php echo date( "Y" ) ?>, <?php echo $set['siteName'];  ?>
    </div>
    <!-- Copyright -->

  </footer>
  <!-- Footer -->







