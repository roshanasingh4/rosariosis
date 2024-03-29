<?php
/**
 * Get Grade Level Info function
 *
 * @package RosarioSIS
 * @subpackage functions
 */

/**
 * Get Grade Level Info
 *
 * @since 11.4 Filter Grade Level
 *
 * @param  integer $grade  Grade Level ID.
 * @param  string  $column TITLE|SHORT_NAME|SORT_ORDER|NEXT_GRADE_ID Column name (optional). Defaults to TITLE.
 *
 * @return string  Grade Level Column content
 */
function GetGrade( $grade, $column = 'TITLE' )
{
	static $grades = null;

	// Column defaults to TITLE.
	if ( $column !== 'TITLE'
		&& ( $column === 'GRADE_ID' // Default from GetStuList().
			|| ! in_array( $column, [ 'TITLE', 'SHORT_NAME', 'SORT_ORDER', 'NEXT_GRADE_ID' ] ) ) )
	{
		$column = 'TITLE';
	}

	if ( ! $grades )
	{
		$grades = DBGet( "SELECT ID,TITLE,SHORT_NAME,SORT_ORDER,NEXT_GRADE_ID
			FROM school_gradelevels", [], [ 'ID' ] );
	}

	if ( ! isset( $grades[ $grade ] ) )
	{
		return '';
	}

	$extra = '';

	if ( $column === 'TITLE' )
	{
		$extra = '<!-- ' . $grades[ $grade ][1]['SORT_ORDER'] . ' -->';
	}

	$return_value = $extra . $grades[ $grade ][1][ $column ];

	/**
	 * Filter Grade Level
	 * Note: edit the $return_value var
	 *
	 * @since 11.4
	 */
	do_action( 'functions/GetGrade.fnc.php|filter_grade_level', [ &$return_value, $column ] );

	return $return_value;
}
