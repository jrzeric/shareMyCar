<?php
class RecordNotFoundException extends Exception
{

	/**
   * Returns an error message in case an record is not found
   *
   * @return string the string of the error message.
   */
	public function get_message() {
    return 'Record not found';
  }
}
?>
