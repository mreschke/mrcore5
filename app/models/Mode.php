<?php

/*
Mode is viewmode, and I liked table name of Views instead of 
View class is already used by laravel
*/
class Mode extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'modes';

	/**
	 * This table does not use automatic timestamps
	 *
	 * @var boolean
	 */
	public $timestamps = false;

	/**
	 * Find a model by its primary key.  Mrcore cacheable eloquent override.
	 *
	 * @param  mixed  $id
	 * @param  array  $columns
	 * @return \Illuminate\Database\Eloquent\Model|static|null
	 */
	public static function find($id, $columns = array('*'))
	{
		return Mrcore\Cache::remember(strtolower(get_class())."_$id", function() use($id, $columns) {
			return parent::find($id, $columns);
		});		
	}
	
	/**
	 * Get all modes as array
	 *
	 * @return assoc array of modes
	 */
	public static function allArray($keyField = 'id', $valueField = 'name')
	{
		return Mrcore\Cache::remember("modes_$keyField-$valueField", function() use($keyField, $valueField)
		{
			return Mode::all()->lists($valueField, $keyField);
		});
	}
}