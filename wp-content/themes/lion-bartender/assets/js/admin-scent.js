/* Lion Bartender — admin: media picker + color sync cho màn hình mùi hương. */
jQuery(function ($) {
  'use strict';

  // Chọn ảnh đại diện qua Thư viện Media.
  $(document).on('click', '.lb-img-pick', function (e) {
    e.preventDefault();
    var $field = $(this).closest('.lb-img-field');
    var frame = wp.media({
      title: 'Chọn ảnh mùi hương',
      multiple: false,
      library: { type: 'image' },
      button: { text: 'Dùng ảnh này' }
    });
    frame.on('select', function () {
      var att = frame.state().get('selection').first().toJSON();
      var url = (att.sizes && att.sizes.medium) ? att.sizes.medium.url : att.url;
      $field.find('.lb-img-id').val(att.id);
      $field.find('.lb-img-preview').attr('src', url).show();
      $field.find('.lb-img-clear').show();
    });
    frame.open();
  });

  // Xóa ảnh.
  $(document).on('click', '.lb-img-clear', function (e) {
    e.preventDefault();
    var $field = $(this).closest('.lb-img-field');
    $field.find('.lb-img-id').val('');
    $field.find('.lb-img-preview').attr('src', '').hide();
    $(this).hide();
  });

  // Đồng bộ ô màu (color picker) <-> ô text hex.
  $(document).on('input change', '.lb-color-sync', function () {
    $(this).closest('td, .form-field').find('input[name="lb_color"]').val($(this).val());
  });
  $(document).on('input change', 'input[name="lb_color"]', function () {
    var v = $(this).val();
    if (/^#[0-9a-fA-F]{6}$/.test(v)) {
      $(this).closest('td, .form-field').find('.lb-color-sync').val(v);
    }
  });

  // Thêm phân loại (mùi có sẵn) cho sản phẩm: dựng thẻ ảnh mới trong lưới.
  function lbEsc(str) {
    return $('<div>').text(str == null ? '' : String(str)).html();
  }
  $(document).on('click', '#lb-add-scent-btn', function (e) {
    e.preventDefault();
    var $sel = $('#lb-add-scent-sel');
    var slug = $sel.val();
    if (!slug) {
      return;
    }
    var map = window.LB_ADD_SCENTS || {};
    var s = map[slug];
    if (!s) {
      return;
    }
    var img = s.img || '';
    var card =
      '<div class="lb-img-field" style="border:1px solid #dcdcde;border-radius:6px;padding:12px;background:#fff">' +
        '<div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;font-weight:600">' +
          '<span style="width:14px;height:14px;border-radius:50%;background:' + lbEsc(s.color) + ';border:1px solid rgba(0,0,0,.15);flex:none"></span>' +
          lbEsc(s.name) +
        '</div>' +
        '<div style="background:#11151f;border-radius:4px;min-height:120px;display:flex;align-items:center;justify-content:center;padding:8px;margin-bottom:8px">' +
          '<img class="lb-img-preview" src="' + lbEsc(img) + '" alt="" style="max-height:120px;max-width:100%;' + (img ? '' : 'display:none;') + '" />' +
        '</div>' +
        '<input type="hidden" class="lb-img-id" name="lb_scent_images[' + lbEsc(slug) + ']" value="0" />' +
        '<input type="hidden" name="lb_add_scents[]" value="' + lbEsc(slug) + '" />' +
        '<button type="button" class="button button-small lb-img-pick">Chọn ảnh</button> ' +
        '<button type="button" class="button button-small lb-img-clear" style="display:none">Dùng mặc định</button>' +
      '</div>';
    $('#lb-scent-grid').append(card);
    $sel.find('option[value="' + slug + '"]').remove();
    if ($sel.find('option').length <= 1) {
      $sel.val('').prop('disabled', true);
      $('#lb-add-scent-btn').prop('disabled', true);
      $sel.find('option[value=""]').text('— Đã thêm tất cả mùi —');
    } else {
      $sel.val('');
    }
  });

  // Sau khi thêm term mới qua AJAX, reset preview ảnh ở form thêm.
  $(document).ajaxComplete(function (e, xhr, settings) {
    if (settings && settings.data && settings.data.indexOf('action=add-tag') !== -1) {
      var $add = $('#addtag .lb-img-field');
      $add.find('.lb-img-id').val('');
      $add.find('.lb-img-preview').attr('src', '').hide();
      $add.find('.lb-img-clear').hide();
    }
  });
});
