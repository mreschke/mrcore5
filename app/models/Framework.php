<?php

class Framework extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'frameworks';

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
	 * Get all frameworks as array
	 *
	 * @return assoc array of frameworks
	 */
	public static function allArray($keyField = 'id', $valueField = 'name')
	{
		return Mrcore\Cache::remember("frameworks_$keyField-$valueField", function() use($keyField, $valueField)
		{
			return Framework::all()->lists($valueField, $keyField);
		});
	}

}