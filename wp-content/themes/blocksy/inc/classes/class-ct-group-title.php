<?php
/**
 * Group title
 *
 * @package Blocksy
 */

/**
 * Implement group title
 */
class Blocksy_Group_Title extends WP_Customize_Section {
	/**
	 * Type of this section.
	 *
	 * @var string
	 */
	public $type = 'ct-group-title';

	/**
	 * Special categorization for the section.
	 *
	 * @var string
	 */
	public $kind = 'default';

	/**
	 * Output
	 */
	public function render() {
		$description = $this->description;
		$class = 'accordion-section ct-group-title';

		if ( 'divider' === $this->kind ) {
			$class = 'accordion-section ct-group-divider';
		}

		if ( 'option' === $this->kind ) {
			$class = 'accordion-section ct-option-title';
		}

		?>

		<li
			id="accordion-section-<?php echo esc_attr( $this->id ); ?>"
			class="<?php echo esc_attr( $class ); ?>">
			<h3><?php echo esc_html( $this->title ); ?></h3>

			<?php if ( ! empty( $description ) ) { ?>
				<span class="description"><?php echo esc_html( $description ); ?></span>
			<?php } ?>
		</li>
		<?php
	}
}

