<?php
/**
 * Eclipse icon html and css.
 *
 */

 ?>

 <div class="lds-css ng-scope">
   <div class="lds-eclipse preloader-plus-default-icons">
     <div></div>
   </div>
 <style type="text/css">@keyframes lds-eclipse {
   0% {
     -webkit-transform: rotate(0deg);
     transform: rotate(0deg);
   }
   50% {
     -webkit-transform: rotate(180deg);
     transform: rotate(180deg);
   }
   100% {
     -webkit-transform: rotate(360deg);
     transform: rotate(360deg);
   }
 }
 @-webkit-keyframes lds-eclipse {
   0% {
     -webkit-transform: rotate(0deg);
     transform: rotate(0deg);
   }
   50% {
     -webkit-transform: rotate(180deg);
     transform: rotate(180deg);
   }
   100% {
     -webkit-transform: rotate(360deg);
     transform: rotate(360deg);
   }
 }
 .lds-eclipse div {
   -webkit-animation: lds-eclipse 1s linear infinite;
   animation: lds-eclipse 1s linear infinite;
   width: 100%;
   height: 100%;
   border-radius: 50%;
   box-shadow: 0 4px 0 0 <?php echo esc_attr( $settings['text_color'] ) ?>;
 }
 </style></div>
