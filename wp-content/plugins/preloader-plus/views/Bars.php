<?php
/**
 * Bars icon html and css.
 *
 */

 ?>

 <div class="lds-css ng-scope">
   <div class="lds-bars preloader-plus-default-icons">
     <div></div>
     <div></div>
     <div></div>
     <div></div>
   </div>
 <style type="text/css">@keyframes lds-bars {
   0% {
     opacity: 1;
   }
   50% {
     opacity: 0.5;
   }
   100% {
     opacity: 1;
   }
 }
 @-webkit-keyframes lds-bars {
   0% {
     opacity: 1;
   }
   50% {
     opacity: 0.5;
   }
   100% {
     opacity: 1;
   }
 }
 .lds-bars div {
   width: 20%;
   height: 80%;
   -webkit-animation: lds-bars 1s cubic-bezier(0.5, 0, 0.5, 1) infinite;
   animation: lds-bars 1s cubic-bezier(0.5, 0, 0.5, 1) infinite;
 }
 .lds-bars div:nth-child(1) {
   background: <?php echo esc_attr( $settings['text_color'] ) ?>;
   -webkit-animation-delay: -0.6s;
   animation-delay: -0.6s;
 }
 .lds-bars div:nth-child(2) {
   background: <?php echo esc_attr( $settings['text_color'] ) ?>;
   -webkit-animation-delay: -0.4s;
   animation-delay: -0.4s;
 }
 .lds-bars div:nth-child(3) {
   background: <?php echo esc_attr( $settings['text_color'] ) ?>;
   -webkit-animation-delay: -0.2s;
   animation-delay: -0.2s;
 }
 .lds-bars div:nth-child(4) {
   background: <?php echo esc_attr( $settings['text_color'] ) ?>;
 }
 .lds-bars {
	 display: flex;
 	 flex-flow: row nowrap;
 	 align-items: center;
 	 justify-content: space-between;
 }
 </style></div>
