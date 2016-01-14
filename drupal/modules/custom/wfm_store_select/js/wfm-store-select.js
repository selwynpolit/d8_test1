(function ($, Drupal, drupalSettings) {
//(function ($) {

  'use strict';

  /**
   * @namespace
   */
  Drupal.storeSelect = {};
  Drupal.behaviors.makeThisMyStore = {
    attach: function (event) {
      $('.add_store').on('click', function (event) {
        var href = $(this).attr('href');
        var storeTLC = href.substr(href.length - 3);
        console.log(tlc);
        setCookie('store', storeTLC,7);
        event.preventDefault();
      });
    }
  };
})(jQuery,Drupal);

function setCookie(cname, cvalue, exdays) {
  console.log('writing cookie');
  var d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  var expires = "expires="+d.toUTCString();
  document.cookie = cname + "=" + cvalue + "; " + expires;
}
