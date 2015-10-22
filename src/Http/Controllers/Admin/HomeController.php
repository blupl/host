<?php namespace Blupl\Host\Http\Controllers\Admin;

use Blupl\Host\Model\Host;
use Illuminate\Support\Facades\Input;
use Blupl\Host\Processor\Host as HostProcessor;
use Orchestra\Foundation\Http\Controllers\AdminController;

class HomeController extends AdminController
{

    public function __construct(HostProcessor $processor)
    {
        $this->processor = $processor;

        parent::__construct();
    }

    protected function setupFilters()
    {
        $this->beforeFilter('control.csrf', ['only' => 'delete']);
    }

    /**
     * Get landing page.
     *
     * @return mixed
     */
    public function index()
    {
        return $this->processor->index($this);
    }

    public function indexSucceed(array $data)
    {
        set_meta('title', 'blupl/host::title.host');

        return view('blupl/host::index', $data);
    }


    /**
     * Show a role.
     *
     * @param  int  $roles
     *
     * @return mixed
     */
    public function show($host)
    {
        return $this->edit($host);
    }

    /**
     * Create a new role.
     *
     * @return mixed
     */
    public function create()
    {
        return $this->processor->create($this);
    }

    /**
     * Edit the role.
     *
     * @param  int  $roles
     *
     * @return mixed
     */
     public function edit($host)
     {
        return $this->processor->edit($this, $host);
     }

    /**
     * Create the role.
     *
     * @return mixed
     */
     public function store()
     {
        return $this->processor->store($this, Input::all());
     }

    /**
     * Update the role.
     *
     * @param  int  $roles
     *
     * @return mixed
     */
    public function update($host)
    {
        return $this->processor->update($this, Input::all(), $host);
    }

    /**
     * Request to delete a role.
     *
     * @param  int  $roles
     *
     * @return mixed;
     */
    public function delete($host)
    {
        return $this->destroy($host);
    }

    /**
     * Request to delete a role.
     *
     * @param  int  $roles
     *
     * @return mixed
     */
    public function destroy($host)
    {
        return $this->processor->destroy($this, $host);
    }


    /**
     * Response when create role page succeed.
     *
     * @param  array  $data
     *
     * @return mixed
     */
    public function createSucceed(array $data)
    {
        set_meta('title', trans('blupl/host::title.host.create'));

        return view('blupl/host::edit', $data);
    }

    /**
     * Response when edit role page succeed.
     *
     * @param  array  $data
     *
     * @return mixed
     */
    public function editSucceed(array $data)
    {
        set_meta('title', trans('blupl/host::title.host.update'));

        return view('blupl/host::edit', $data);
    }

    /**
     * Response when storing role failed on validation.
     *
     * @param  object  $validation
     *
     * @return mixed
     */
     public function storeValidationFailed($validation)
     {
        return $this->redirectWithErrors(handles('orchestra::host/reporter/create'), $validation);
     }

    /**
     * Response when storing role failed.
     *
     * @param  array  $error
     *
     * @return mixed
     */
     public function storeFailed(array $error)
     {
        $message = trans('orchestra/foundation::response.db-failed', $error);

        return $this->redirectWithMessage(handles('orchestra::host/reporter'), $message);
     }

    /**
     * Response when storing user succeed.
     *
     * @param  \Orchestra\Model\Role  $role
     *
     * @return mixed
     */
     public function storeSucceed(host $host)
     {
        $message = trans('blupl/host::response.host.create', [
            'name' => $host->getAttribute('name')
        ]);

            return $this->redirectWithMessage(handles('orchestra::host/reporter'), $message);
     }

    /**
     * Response when updating role failed on validation.
     *
     * @param  object  $validation
     * @param  int     $id
     *
     * @return mixed
     */
     public function updateValidationFailed($validation, $id)
     {
        return $this->redirectWithErrors(handles("orchestra::host/reporter/{$id}/edit"), $validation);
     }

    /**
     * Response when updating role failed.
     *
     * @param  array  $errors
     *
     * @return mixed
     */
     public function updateFailed(array $errors)
     {
        $message = trans('orchestra/foundation::response.db-failed', $errors);

        return $this->redirectWithMessage(handles('orchestra::host/reporter'), $message);
     }

    /**
     * Response when updating role succeed.
     */
    public function updateSucceed(host $host)
    {
        $message = trans('orchestra/control::response.roles.update', [
            'name' => $host->getAttribute('name')
        ]);

        return $this->redirectWithMessage(handles('orchestra::host'), $message);
    }

    /**
     * Response when deleting role failed.
     *
     * @param  array  $error
     *
     * @return mixed
     */
    public function destroyFailed(array $error)
    {
        $message = trans('orchestra/foundation::response.db-failed', $error);

        return $this->redirectWithMessage(handles('orchestra::host'), $message);
    }

    /**
     * Response when updating role succeed.
     *
     * @param  \Orchestra\Model\Role  $role
     *
     * @return mixed
     */
    public function destroySucceed(host $host)
    {
        $message = trans('orchestra/control::response.roles.delete', [
            'name' => $host->getAttribute('name')
        ]);

   ;     return $this->redirectWithMessage(handles('orchestra::host'), $message);
    }

    /**
     * Response when user verification failed.
     *
     * @return mixed
     */
    public function userVerificationFailed()
    {
        return $this->suspend(500);
    }

}