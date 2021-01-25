<?php
/**
 * DualRing icon html and css.
 *
 */

 ?>

 <div class="lds-css ng-scope">
   <div class="lds-dual-ring preloader-plus-default-icons">
     <div></div>
   </div>
 <style type="text/css">@keyframes lds-dual-ring {
   0% {
     -webkit-transform: rotate(0);
     transform: rotate(0);
   }
   100% {
     -webkit-transform: rotate(360deg);
     transform: rotate(360deg);
   }
 }
 @-webkit-keyframes lds-dual-ring {
   0% {
     -webkit-transform: rotate(0);
     transform: rotate(0);
   }
   100% {
     -webkit-transform: rotate(360deg);
     transform: rotate(360deg);
   }
 }
 .lds-dual-ring div {
   width: 100%;
   height: 100%;
   border-radius: 50%;
   border: 8px solid #000;
   border-color: <?php echo esc_attr( $settings['text_color'] ) ?> transparent <? echo esc_attr( $settings['text_color'] ) ?> transparent;
   -webkit-animation: lds-dual-ring 1s linear infinite;
   animation: lds-dual-ring 1s linear infinite;
 }
 </style></div>
