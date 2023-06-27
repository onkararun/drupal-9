/**
 * @file
 * Contains js script.
 */

(function ($, Drupal) {
  'use strict';
  Drupal.behaviors.countries_field = {
    attach: function (context, settings) {
      $('[data-id="field-continent"]', context).on('change', function (e) {
        let path = Drupal.url('api/countries_field/countries');
        let continentId = $(this).children('option:selected').val();
        continentId = (continentId === '') ? 'all' : continentId;
        let request = $.ajax({
          url: path,
          method: 'POST',
          data: {continent_code: continentId},
          dataType: 'json'
        });
        request.done(function (msg) {
          let select = $('[data-id="field-country"]');
          // Clear select box.
          select.empty();
          // Add default values.
          select.append('<option value="">' + Drupal.t('- None -') + "</option>");
          // Return select.
          for (let j = 0; j < msg.length; j++) {
            select.append('<option value="' + msg[j].code + '">' + msg[j].name + " </option>");
          }
        });

        request.fail(function (jqXHR, textStatus) {
          console.log('Request failed: ' + textStatus);
        });
      });
    }
  };
})(jQuery, Drupal);
