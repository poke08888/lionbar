<?php
/**
 * Lion Bartender — meta box "Thông tin sản phẩm" cho CPT lb_product.
 *
 * Cho phép sửa toàn bộ nội dung hiển thị ở trang chi tiết sản phẩm
 * (single-lb_product.php): tagline, giá, dung tích, nhãn, mô tả (blurb),
 * danh sách đặc điểm (features), loại sản phẩm, ảnh mặc định, thứ tự.
 *
 * Tất cả lưu ở post meta — khớp với lb_product_data() trong inc/helpers.php.
 * Tên sản phẩm = tiêu đề bài viết; Mùi hương = taxonomy lb_scent (ô bên phải);
 * Ảnh theo từng mùi = meta box trong inc/admin-product.php.
 *
 * @package Lion_Bartender
 */

defined( 'ABSPATH' ) || exit;

/* Danh sách loại sản phẩm (khớp lb_shop_filters(), bỏ "all"). */
function lb_product_type_options() {
	$filters = lb_shop_filters();
	unset( $filters['all'] );
	return $filters;
}

/* Đăng ký meta box — ưu tiên cao để nằm trên cùng cột nội dung. */
add_action( 'add_meta_boxes', 'lb_product_fields_metabox' );
function lb_product_fields_metabox() {
	add_meta_box(
		'lb_product_fields',
		'Thông tin sản phẩm',
		'lb_product_fields_box',
		'lb_product',
		'normal',
		'high'
	);
}

/* Một dòng field text/number. */
function lb_pf_text( $name, $label, $value, $type = 'text', $desc = '', $attrs = '' ) {
	printf(
		'<p style="margin:0 0 14px"><label for="%1$s" style="display:block;font-weight:600;margin-bottom:4px">%2$s</label>'
		. '<input type="%3$s" id="%1$s" name="%1$s" value="%4$s" class="widefat" %5$s />%6$s</p>',
		esc_attr( $name ),
		esc_html( $label ),
		esc_attr( $type ),
		esc_attr( $value ),
		$attrs, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- literal attrs.
		$desc ? '<span class="description" style="display:block;margin-top:3px">' . esc_html( $desc ) . '</span>' : ''
	);
}

function lb_product_fields_box( $post ) {
	wp_nonce_field( 'lb_save_product_fields', 'lb_product_fields_nonce' );

	$pid       = $post->ID;
	$type      = get_post_meta( $pid, 'lb_type', true );
	$typeLabel = get_post_meta( $pid, 'lb_type_label', true );
	$tagline   = get_post_meta( $pid, 'lb_tagline', true );
	$price     = get_post_meta( $pid, 'lb_price', true );
	$oldPrice  = get_post_meta( $pid, 'lb_old_price', true );
	$volume    = get_post_meta( $pid, 'lb_volume', true );
	$badge     = get_post_meta( $pid, 'lb_badge', true );
	$blurb     = get_post_meta( $pid, 'lb_blurb', true );
	$features  = get_post_meta( $pid, 'lb_features', true );
	$heroImg   = get_post_meta( $pid, 'lb_hero_img', true );
	$order     = get_post_meta( $pid, 'lb_order', true );
	$feat_txt  = $features ? implode( "\n", explode( '|', $features ) ) : '';
	?>
	<style>
		.lb-pf-grid{display:grid;grid-template-columns:1fr 1fr;gap:0 18px}
		.lb-pf-full{grid-column:1 / -1}
		#lb_product_fields textarea.widefat{min-height:70px}
	</style>
	<p class="description" style="margin:0 0 14px">Nội dung hiển thị ở trang chi tiết sản phẩm. <strong>Tên sản phẩm</strong> sửa ở ô tiêu đề phía trên; <strong>Mùi hương</strong> chọn ở ô bên phải.</p>

	<div class="lb-pf-grid">
		<div class="lb-pf-full">
			<p style="margin:0 0 14px">
				<label for="lb_tagline" style="display:block;font-weight:600;margin-bottom:4px">Tagline (dòng nghiêng dưới tên)</label>
				<input type="text" id="lb_tagline" name="lb_tagline" value="<?php echo esc_attr( $tagline ); ?>" class="widefat" placeholder="Khô thoáng 24h · Kích hoạt theo nhiệt" />
			</p>
		</div>

		<div>
			<p style="margin:0 0 14px">
				<label for="lb_type" style="display:block;font-weight:600;margin-bottom:4px">Loại sản phẩm</label>
				<select id="lb_type" name="lb_type" class="widefat">
					<?php foreach ( lb_product_type_options() as $val => $lbl ) : ?>
						<option value="<?php echo esc_attr( $val ); ?>" <?php selected( $type, $val ); ?>><?php echo esc_html( $lbl ); ?></option>
					<?php endforeach; ?>
				</select>
				<span class="description" style="display:block;margin-top:3px">Chi phối lọc ở trang cửa hàng &amp; cách hiển thị (nhãn/chai theo mùi).</span>
			</p>
		</div>
		<div><?php lb_pf_text( 'lb_type_label', 'Nhãn loại (hiển thị)', $typeLabel, 'text', 'VD: Lăn nách, Xịt khử mùi…' ); ?></div>

		<div><?php lb_pf_text( 'lb_price', 'Giá (đ)', $price, 'number', 'Chỉ nhập số, VD: 89000', 'min="0" step="1000"' ); ?></div>
		<div><?php lb_pf_text( 'lb_old_price', 'Giá gạch (đ)', $oldPrice, 'number', 'Để trống hoặc 0 nếu không giảm giá', 'min="0" step="1000"' ); ?></div>

		<div><?php lb_pf_text( 'lb_volume', 'Dung tích / quy cách', $volume, 'text', 'VD: 50ml, 330g, Bộ 2 món' ); ?></div>
		<div><?php lb_pf_text( 'lb_badge', 'Nhãn góc (badge)', $badge, 'text', 'VD: Bán chạy — để trống nếu không có' ); ?></div>

		<div class="lb-pf-full">
			<p style="margin:0 0 14px">
				<label for="lb_blurb" style="display:block;font-weight:600;margin-bottom:4px">Mô tả ngắn (blurb)</label>
				<textarea id="lb_blurb" name="lb_blurb" class="widefat" rows="3" placeholder="Đoạn mô tả nổi bật dưới giá."><?php echo esc_textarea( $blurb ); ?></textarea>
				<span class="description" style="display:block;margin-top:3px">Đoạn mô tả in đậm hiển thị ngay dưới giá ở trang chi tiết.</span>
			</p>
		</div>

		<div class="lb-pf-full">
			<p style="margin:0 0 14px">
				<label for="lb_features" style="display:block;font-weight:600;margin-bottom:4px">Đặc điểm (features)</label>
				<textarea id="lb_features" name="lb_features" class="widefat" rows="5" placeholder="Mỗi dòng một đặc điểm"><?php echo esc_textarea( $feat_txt ); ?></textarea>
				<span class="description" style="display:block;margin-top:3px"><strong>Mỗi dòng một ý</strong> — hiển thị thành danh sách có dấu tích ở cuối trang.</span>
			</p>
		</div>

		<div><?php lb_pf_text( 'lb_hero_img', 'Ảnh mặc định (tên file / URL)', $heroImg, 'text', 'Tên file trong assets/images hoặc URL. Thường để trống để dùng tem theo mùi.' ); ?></div>
		<div><?php lb_pf_text( 'lb_order', 'Thứ tự sắp xếp', $order, 'number', 'Số nhỏ hiển thị trước', 'min="0" step="1"' ); ?></div>
	</div>
	<?php
}

/* Lưu meta. */
add_action( 'save_post_lb_product', 'lb_save_product_fields' );
function lb_save_product_fields( $post_id ) {
	if ( ! isset( $_POST['lb_product_fields_nonce'] )
		|| ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['lb_product_fields_nonce'] ) ), 'lb_save_product_fields' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// Trường text đơn giản.
	$text_fields = array(
		'lb_type_label' => 'lb_type_label',
		'lb_tagline'    => 'lb_tagline',
		'lb_volume'     => 'lb_volume',
		'lb_badge'      => 'lb_badge',
		'lb_hero_img'   => 'lb_hero_img',
	);
	foreach ( $text_fields as $key => $meta ) {
		$val = isset( $_POST[ $key ] ) ? sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) : '';
		update_post_meta( $post_id, $meta, $val );
	}

	// Loại sản phẩm — chỉ nhận giá trị hợp lệ.
	$type    = isset( $_POST['lb_type'] ) ? sanitize_key( wp_unslash( $_POST['lb_type'] ) ) : '';
	$allowed = array_keys( lb_product_type_options() );
	if ( in_array( $type, $allowed, true ) ) {
		update_post_meta( $post_id, 'lb_type', $type );
	}

	// Số.
	update_post_meta( $post_id, 'lb_price', isset( $_POST['lb_price'] ) ? absint( $_POST['lb_price'] ) : 0 );
	update_post_meta( $post_id, 'lb_old_price', isset( $_POST['lb_old_price'] ) ? absint( $_POST['lb_old_price'] ) : 0 );
	update_post_meta( $post_id, 'lb_order', isset( $_POST['lb_order'] ) ? absint( $_POST['lb_order'] ) : 0 );

	// Mô tả (blurb) — giữ xuống dòng.
	$blurb = isset( $_POST['lb_blurb'] ) ? sanitize_textarea_field( wp_unslash( $_POST['lb_blurb'] ) ) : '';
	update_post_meta( $post_id, 'lb_blurb', $blurb );

	// Features: textarea mỗi dòng một ý -> lưu dạng "a|b|c".
	$raw   = isset( $_POST['lb_features'] ) ? sanitize_textarea_field( wp_unslash( $_POST['lb_features'] ) ) : '';
	$lines = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', $raw ) ), 'strlen' );
	update_post_meta( $post_id, 'lb_features', implode( '|', $lines ) );
}
