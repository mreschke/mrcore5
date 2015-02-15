<?php

class Tag extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tags';

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

	/*
	 * Clear all cache
	 *
	 */
	public static function forgetCache()
	{
		Cache::forget('tags_id-name');
		Cache::forget('tags');
	}

	/**
	 * Get all tags
	 *
	 * @return array of tags
	 */
	public static function getAll()
	{
		return Mrcore\Cache::remember("tags", function()
		{
			return Tag::orderBy('name')->get();
		});
	}

	/**
	 * Get all tags as array
	 *
	 * @return assoc array of tags
	 */
	public static function allArray($keyField = 'id', $valueField = 'name')
	{
		$function = function() use ($keyField, $valueField) {
			return Tag::all()->lists($valueField, $keyField);
		};
		
		//Only cache if using default id/name
		if ($keyField == 'id' && $valueField == 'name') {
			return Mrcore\Cache::remember("tags_$keyField-$valueField", $function);
		} else {
			return $function;
		}
	}

}