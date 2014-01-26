<?php


/**
* user controller
*/
class adminsController extends BaseController
{
	public function getIndex()
	{
		return AdminsModel::all();
	}

	public function postCreate()
	{
		$admin = new AdminsModel;
		if(!$admin->saveItem($admin)) return Response::json('Error : failed to validate',400);;
		return Response::json('New admin has been created successfuly',200);
	}

	public function postUpdate()
	{
		$admin = AdminsModel::find(Input::get('id'));
		if(!$admin->saveItem($admin)) return Response::json('Error : failed to validate',400);;
		return Response::json('Admin has been updated successfuly',200);	
	}

	public function getDelete($id = 0)
	{
		$admin = AdminsModel::find($id);
		$admin->delete();
		return Response::json('Admin has been deleted successfuly',200);
	}

}