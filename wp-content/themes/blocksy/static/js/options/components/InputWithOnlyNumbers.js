import { createElement, Component } from '@wordpress/element'
import _ from 'underscore'
import { __ } from 'ct-i18n'
import cls from 'classnames';

const InputWithOnlyNumbers = ({
  disabled,
  className = '',
  value,
  onBlur,
  onChange,
  placeholder = __('Default', 'blocksy')
}) => (
  <input
    type="text"
    value={value}
    onKeyDown={e => {
      // Allow: backspace, delete, tab, escape, enter and.
      if (
        // Allow Esc
        _.contains([46, 8, 9, 27, 13, 110, 190, 27], e.keyCode) ||
        // Allow: Ctrl+A.
        (e.keyCode == 65 && e.ctrlKey === true) ||
        // Allow -.
        e.keyCode == 109 ||
        e.keyCode == 189 ||
        e.keyCode == 173 ||
        // Allow: Ctrl+C.
        (e.keyCode == 67 && e.ctrlKey === true) ||
        // Allow: Ctrl+X.
        (e.keyCode == 88 && e.ctrlKey === true) ||
        // Allow: home, end, left, right.
        (e.keyCode >= 35 &&
          e.keyCode <= 39 &&
          e.keyCode !== 38 &&
          e.keyCode !== 40)
      ) {
        // Let it happen, don't do anything.
        return
      }

      /**
       * Arrow up
       */
      if (e.keyCode === 38) {
        if (_.isNumber(parseInt(value, 10))) {
          onChange(parseInt(value, 10) + (e.shiftKey ? 10 : 1), true)
        }
      }

      /**
       * Arrow down
       */
      if (e.keyCode === 40) {
        if (_.isNumber(parseInt(value, 10))) {
          onChange(parseInt(value, 10) - (e.shiftKey ? 10 : 1), true)
        }
      }

      // Ensure that it is a number and stop the keypress.
      if (
        (e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) &&
        (e.keyCode < 96 || e.keyCode > 105)
      ) {
        e.preventDefault()
      }
    }}
    onChange={({ target: { value } }) => onChange(value)}
    placeholder={placeholder}
    onBlur={() => onBlur && onBlur}
    className={cls({
      inactive: value === 'auto'
    })}
  />
)

export default InputWithOnlyNumbers
