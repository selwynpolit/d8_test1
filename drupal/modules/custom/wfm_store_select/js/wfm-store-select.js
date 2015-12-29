/**
 * Created by selwyn.polit on 12/29/15.
 */

(function ($, Drupal) {

  'use strict';
  console.log('tom was here');
  /**
   * @namespace
   */
  Drupal.storeSelect = {};

  /**
   * Improve the user experience of the views edit interface.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *   Attaches toggling of SQL rewrite warning on the corresponding checkbox.
   */
  Drupal.behaviors.makeThisMyStore = {

    attach: function (event) {
      console.log('tom was here inside attach');
      $('.add_store').on('click', function () {
        alert('you bastard!');
        event.preventDefault();
      });
    }
  };
})();