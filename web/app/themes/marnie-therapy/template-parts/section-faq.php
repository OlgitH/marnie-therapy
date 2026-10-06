<?php
/**
 * FAQ section (ACF flexible content layout: faq).
 *
 * Accordion is built from a native <button> with aria-expanded and a
 * matching aria-controls/aria-labelledby'd panel, so it's fully operable
 * by keyboard and announced correctly by screen readers even before JS
 * (main.js) enhances it — without JS every answer is simply visible.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading    = get_sub_field( 'heading' ) ?: 'Frequently Asked Questions';
$items      = get_sub_field( 'items' );
$photos     = array_filter( array( get_sub_field( 'photo_1' ), get_sub_field( 'photo_2' ) ) ); // attachment IDs
?>
<section class="section" id="faq" aria-labelledby="faq-heading">
	<div class="container">
		<div class="faq-heading">
			<h2 id="faq-heading"><?php echo esc_html( $heading ); ?></h2>
		</div>

		<div class="faq<?php echo $photos ? ' faq--has-photos' : ''; ?>">
		<?php if ( $items ) : ?>
			<div class="faq-list" data-faq-list>
				<?php foreach ( $items as $index => $item ) : ?>
					<?php
					if ( empty( $item['question'] ) ) {
						continue;
					}
					$trigger_id = 'faq-trigger-' . $index;
					$panel_id   = 'faq-panel-' . $index;
					?>
					<div class="faq-item">
						<h3>
							<button
								type="button"
								class="faq-item__trigger"
								id="<?php echo esc_attr( $trigger_id ); ?>"
								aria-expanded="false"
								aria-controls="<?php echo esc_attr( $panel_id ); ?>"
							>
								<span><?php echo esc_html( $item['question'] ); ?></span>
								<span class="faq-item__icon" aria-hidden="true"></span>
							</button>
						</h3>
						<div
							id="<?php echo esc_attr( $panel_id ); ?>"
							class="faq-item__panel"
							role="region"
							aria-labelledby="<?php echo esc_attr( $trigger_id ); ?>"
						>
							<?php echo wp_kses_post( $item['answer'] ); ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( $photos ) : ?>
			<div class="faq__photos">
				<?php foreach ( $photos as $photo ) : ?>
					<div class="faq__photo">
						<?php
						echo wp_get_attachment_image(
							$photo,
							'large',
							false,
							array(
								'sizes'    => '(min-width: 56rem) 24rem, 100vw',
								'loading'  => 'lazy',
								'decoding' => 'async',
							)
						);
						?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		</div>
	</div>
</section>
