<?php
/**
 * Rolling icon html and css.
 *
 */

 ?>

 <div class="lds-css ng-scope">
   <div class="lds-rolling preloader-plus-default-icons">
     <div></div>
   </div>
 <style type="text/css">@keyframes lds-rolling {
   0% {
     -webkit-transform: rotate(0deg);
     transform: rotate(0deg);
   }
   100% {
     -webkit-transform: rotate(360deg);
     transform: rotate(360deg);
   }
 }
 @-webkit-keyframes lds-rolling {
   0% {
     -webkit-transform: rotate(0deg);
     transform: rotate(0deg);
   }
   100% {
     -webkit-transform: rotate(360deg);
     transform: rotate(360deg);
   }
 }
 .lds-rolling div,
 .lds-rolling div:after {
   width: 100%;
   height: 100%;
   border: 10px solid <?php echo esc_attr( $settings['text_color'] ) ?>;
   border-top-color: transparent;
   border-radius: 50%;
 }
 .lds-rolling div {
   -webkit-animation: lds-rolling 1s linear infinite;
   animation: lds-rolling 1s linear infinite;
 }
 .lds-rolling div:after {
   -webkit-transform: rotate(90deg);
   transform: rotate(90deg);
 }
 </style></div>
