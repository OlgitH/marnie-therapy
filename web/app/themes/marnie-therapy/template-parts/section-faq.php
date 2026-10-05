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
$ukcp_logo  = get_field( 'ukcp_logo', 'option' );
$bcpc_logo  = get_field( 'bcpc_logo', 'option' );
?>
<section class="section" id="faq" aria-labelledby="faq-heading">
	<div class="container">
		<div class="faq-heading">
			<h2 id="faq-heading"><?php echo esc_html( $heading ); ?></h2>

			<?php if ( $ukcp_logo || $bcpc_logo ) : ?>
				<div class="faq-heading__logos">
					<?php if ( $ukcp_logo ) : ?>
						<img src="<?php echo esc_url( $ukcp_logo['sizes']['thumbnail'] ?? $ukcp_logo['url'] ); ?>" alt="<?php echo esc_attr( $ukcp_logo['alt'] ?: 'UKCP — UK Council for Psychotherapy member' ); ?>" width="120" height="48" loading="lazy" />
					<?php endif; ?>
					<?php if ( $bcpc_logo ) : ?>
						<img src="<?php echo esc_url( $bcpc_logo['sizes']['thumbnail'] ?? $bcpc_logo['url'] ); ?>" alt="<?php echo esc_attr( $bcpc_logo['alt'] ?: 'Bath Centre for Counselling and Psychotherapy' ); ?>" width="120" height="48" loading="lazy" />
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>

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
	</div>
</section>
