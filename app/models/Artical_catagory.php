<?php

class artical_catagory extends Eloquent{

    /**
     * @var string
     */
    protected $table = 'artical_catagory';

    /**
     * the attribute that allow to set value together
     *
     * @var array
     */
    protected $fillable = array('artical_id','catagory_id');
}
