<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			5th June, 2020
	@created		7th April, 2020
	@package		SP Nas
	@subpackage		nas.php
	@author			Adolfo Zignago <https://www.esmartit.es>	
	@copyright		Copyright (C) 2020. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\Utilities\ArrayHelper;

/**
 * Nas Controller
 */
class SpnasControllerNas extends JControllerForm
{
	/**
	 * Current or most recently performed task.
	 *
	 * @var    string
	 * @since  12.2
	 * @note   Replaces _task.
	 */
	protected $task;

	/**
	 * Class constructor.
	 *
	 * @param   array  $config  A named array of configuration variables.
	 *
	 * @since   1.6
	 */
	public function __construct($config = array())
	{
		$this->view_list = 'listnas'; // safeguard for setting the return view listing to the default site view.
		parent::__construct($config);
	}

        /**
	 * Method override to check if you can add a new record.
	 *
	 * @param   array  $data  An array of input data.
	 *
	 * @return  boolean
	 *
	 * @since   1.6
	 */
	protected function allowAdd($data = array())
	{
		// Get user object.
		$user = JFactory::getUser();
		// Access check.
		$access = $user->authorise('nas.access', 'com_spnas');
		if (!$access)
		{
			return false;
		}

		// In the absense of better information, revert to the component permissions.
		return parent::allowAdd($data);
	}

	/**
	 * Method override to check if you can edit an existing record.
	 *
	 * @param   array   $data  An array of input data.
	 * @param   string  $key   The name of the key for the primary key.
	 *
	 * @return  boolean
	 *
	 * @since   1.6
	 */
	protected function allowEdit($data = array(), $key = 'id')
	{
		// get user object.
		$user = JFactory::getUser();
		// get record id.
		$recordId = (int) isset($data[$key]) ? $data[$key] : 0;


		if ($recordId)
		{
			// The record has been set. Check the record permissions.
			$permission = $user->authorise('core.edit', 'com_spnas.nas.' . (int) $recordId);
			if (!$permission)
			{
				if ($user->authorise('core.edit.own', 'com_spnas.nas.' . $recordId))
				{
					// Now test the owner is the user.
					$ownerId = (int) isset($data['created_by']) ? $data['created_by'] : 0;
					if (empty($ownerId))
					{
						// Need to do a lookup from the model.
						$record = $this->getModel()->getItem($recordId);

						if (empty($record))
						{
							return false;
						}
						$ownerId = $record->created_by;
					}

					// If the owner matches 'me' then allow.
					if ($ownerId == $user->id)
					{
						if ($user->authorise('core.edit.own', 'com_spnas'))
						{
							return true;
						}
					}
				}
				return false;
			}
		}
		// Since there is no permission, revert to the component permissions.
		return parent::allowEdit($data, $key);
	}

	/**
	 * Gets the URL arguments to append to an item redirect.
	 *
	 * @param   integer  $recordId  The primary key id for the item.
	 * @param   string   $urlVar    The name of the URL variable for the id.
	 *
	 * @return  string  The arguments to append to the redirect URL.
	 *
	 * @since   1.6
	 */
	protected function getRedirectToItemAppend($recordId = null, $urlVar = 'id')
	{
		// get the referral options (old method use return instead see parent)
		$ref = $this->input->get('ref', 0, 'string');
		$refid = $this->input->get('refid', 0, 'int');

		// get redirect info.
		$append = parent::getRedirectToItemAppend($recordId, $urlVar);

		// set the referral options
		if ($refid && $ref)
                {
			$append = '&ref=' . (string)$ref . '&refid='. (int)$refid . $append;
		}
		elseif ($ref)
		{
			$append = '&ref='. (string)$ref . $append;
		}

		return $append;
	}

	/**
	 * Method to run batch operations.
	 *
	 * @param   object  $model  The model.
	 *
	 * @return  boolean   True if successful, false otherwise and internal error is set.
	 *
	 * @since   2.5
	 */
	public function batch($model = null)
	{
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Set the model
		$model = $this->getModel('Nas', '', array());

		// Preset the redirect
		$this->setRedirect(JRoute::_('index.php?option=com_spnas&view=nases' . $this->getRedirectToListAppend(), false));

		return parent::batch($model);
	}

	/**
	 * Method to cancel an edit.
	 *
	 * @param   string  $key  The name of the primary key of the URL variable.
	 *
	 * @return  boolean  True if access level checks pass, false otherwise.
	 *
	 * @since   12.2
	 */
	public function cancel($key = null)
	{
		// get the referral options
		$this->ref = $this->input->get('ref', 0, 'word');
		$this->refid = $this->input->get('refid', 0, 'int');

		// Check if there is a return value
		$return = $this->input->get('return', null, 'base64');

		$cancel = parent::cancel($key);

		if (!is_null($return) && JUri::isInternal(base64_decode($return)))
		{
			$redirect = base64_decode($return);

			// Redirect to the return value.
			$this->setRedirect(
				JRoute::_(
					$redirect, false
				)
			);
		}
		elseif ($this->refid && $this->ref)
		{
			$redirect = '&view=' . (string)$this->ref . '&layout=edit&id=' . (int)$this->refid;

			// Redirect to the item screen.
			$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . $redirect, false
				)
			);
		}
		elseif ($this->ref)
		{
			$redirect = '&view=' . (string)$this->ref;

			// Redirect to the list screen.
			$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . $redirect, false
				)
			);
		}
		return $cancel;
	}

	/**
	 * Method to save a record.
	 *
	 * @param   string  $key     The name of the primary key of the URL variable.
	 * @param   string  $urlVar  The name of the URL variable if different from the primary key (sometimes required to avoid router collisions).
	 *
	 * @return  boolean  True if successful, false otherwise.
	 *
	 * @since   12.2
	 */
	public function save($key = null, $urlVar = null)
	{
		// get the referral options
		$this->ref = $this->input->get('ref', 0, 'word');
		$this->refid = $this->input->get('refid', 0, 'int');

		// Check if there is a return value
		$return = $this->input->get('return', null, 'base64');
		$canReturn = (!is_null($return) && JUri::isInternal(base64_decode($return)));

		if ($this->ref || $this->refid || $canReturn)
		{
			// to make sure the item is checkedin on redirect
			$this->task = 'save';
		}

//		$saved = parent::save($key, $urlVar);
        $this->checkToken();

        $app   = \JFactory::getApplication();
        $model = $this->getModel();
        $data  = $this->input->post->get('jform', array(), 'array');
        $context = "$this->option.edit.$this->context";
        $task = $this->getTask();

        // Determine the name of the primary key for the data.
        if (empty($key))
        {
            $key = 'id';
        }

        // To avoid data collisions the urlVar may be different from the primary key.
        if (empty($urlVar))
        {
            $urlVar = $key;
        }

        $recordId = $this->input->getInt($urlVar);

        // Populate the row id from the session.
        $data[$key] = $recordId;

        // Validate the posted data.
        // Sometimes the form needs some posted data, such as for plugins and modules.
        $form = $model->getForm($data, false);

        if (!$form)
        {
            $app->enqueueMessage($model->getError(), 'error');

            return false;
        }

        // Send an object which can be modified through the plugin event
        $objData = (object) $data;
        $app->triggerEvent(
            'onContentNormaliseRequestData',
            array($this->option . '.' . $this->context, $objData, $form)
        );
        $data = (array) $objData;

        // Test whether the data is valid.
        $validData = $model->validate($form, $data);

        // Check for validation errors.
        if ($validData === false)
        {
            // Get the validation messages.
            $errors = $model->getErrors();

            // Push up to three validation messages out to the user.
            for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++)
            {
                if ($errors[$i] instanceof \Exception)
                {
                    $app->enqueueMessage($errors[$i]->getMessage(), 'warning');
                }
                else
                {
                    $app->enqueueMessage($errors[$i], 'warning');
                }
            }

            /**
             * We need the filtered value of calendar fields because the UTC normalision is
             * done in the filter and on output. This would apply the Timezone offset on
             * reload. We set the calendar values we save to the processed date.
             */
            $filteredData = $form->filter($data);

            foreach ($form->getFieldset() as $field)
            {
                if ($field->type === 'Calendar')
                {
                    $fieldName = $field->fieldname;

                    if (isset($filteredData[$fieldName]))
                    {
                        $data[$fieldName] = $filteredData[$fieldName];
                    }
                }
            }

            // Save the data in the session.
            $app->setUserState($context . '.data', $data);

            // Redirect back to the edit screen.
            $this->setRedirect(
                \JRoute::_(
                    'index.php?option=' . $this->option . '&view=' . $this->view_item
                    . $this->getRedirectToItemAppend($recordId, $urlVar), false
                )
            );

            return false;
        }

        if (!isset($validData['tags']))
        {
            $validData['tags'] = null;
        }

        // Attempt to save the data.
        if (!$model->save($data))
        {
            // Save the data in the session.
            $app->setUserState($context . '.data', $validData);

            // Redirect back to the edit screen.
            $this->setError(\JText::sprintf('JLIB_APPLICATION_ERROR_SAVE_FAILED', $model->getError()));
            $this->setMessage($this->getError(), 'error');

            $this->setRedirect(
                \JRoute::_(
                    'index.php?option=' . $this->option . '&view=' . $this->view_item
                    . $this->getRedirectToItemAppend($recordId, $urlVar), false
                )
            );

            return false;
        }

        $langKey = $this->text_prefix . ($recordId === 0 && $app->isClient('site') ? '_SUBMIT' : '') . '_SAVE_SUCCESS';
        $prefix  = \JFactory::getLanguage()->hasKey($langKey) ? $this->text_prefix : 'JLIB_APPLICATION';

        $this->setMessage(\JText::_($prefix . ($recordId === 0 && $app->isClient('site') ? '_SUBMIT' : '') . '_SAVE_SUCCESS'));

        // Redirect the user and adjust session state based on the chosen task.
        switch ($task)
        {
            case 'apply':
                // Set the record data in the session.
                $recordId = $model->getState($this->context . '.id');
                $this->holdEditId($context, $recordId);
                $app->setUserState($context . '.data', null);
                $model->checkout($recordId);

                // Redirect back to the edit screen.
                $this->setRedirect(
                    \JRoute::_(
                        'index.php?option=' . $this->option . '&view=' . $this->view_item
                        . $this->getRedirectToItemAppend($recordId, $urlVar), false
                    )
                );
                break;

            case 'save2new':
                // Clear the record id and data from the session.
                $this->releaseEditId($context, $recordId);
                $app->setUserState($context . '.data', null);

                // Redirect back to the edit screen.
                $this->setRedirect(
                    \JRoute::_(
                        'index.php?option=' . $this->option . '&view=' . $this->view_item
                        . $this->getRedirectToItemAppend(null, $urlVar), false
                    )
                );
                break;

            default:
                // Clear the record id and data from the session.
                $this->releaseEditId($context, $recordId);
                $app->setUserState($context . '.data', null);

                $url = 'index.php?option=' . $this->option . '&view=' . $this->view_list
                    . $this->getRedirectToListAppend();

                // Check if there is a return value
                $return = $this->input->get('return', null, 'base64');

                if (!is_null($return) && \JUri::isInternal(base64_decode($return)))
                {
                    $url = base64_decode($return);
                }

                // Redirect to the list screen.
                $this->setRedirect(\JRoute::_($url, false));
                break;
        }

        // Invoke the postSave method to allow for the child class to access the model.
        $this->postSaveHook($model, $data);

        return true;

	}

	/**
	 * Function that allows child controller access to model data
	 * after the data has been saved.
	 *
	 * @param   JModel  &$model     The data model object.
	 * @param   array   $validData  The validated data.
	 *
	 * @return  void
	 *
	 * @since   11.1
	 */
	protected function postSaveHook(JModelLegacy $model, $validData = array())
	{
		return;
	}

}
