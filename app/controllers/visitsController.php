<?php

/**
* visits controller
*/
class visitsController extends BaseController
{
	public function getIndex()
	{
		return Response::json(visitsModel::all(),200);
	}

}