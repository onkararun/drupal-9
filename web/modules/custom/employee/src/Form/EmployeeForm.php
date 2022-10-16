<?php
namespace Drupal\employee\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

Class EmployeeForm extends FormBase{
	/** 
	 * {@inheritdoc}
	 */
	public function getFormId(){
		return 'create_employee';
	}

    /** 
	 * {@inheritdoc}
	 */
	public function buildForm(array $form, FormStateInterface $form_state){
        $genderOption = array(//0=>'Select Gender',
        	'Male'=>'Male','Female'=>'Female','other'=>'other');

		$form['name'] = array(
			'#type'=>'textfield',
			'#title'=>$this->t('Name'),
			'#default_value'=>'',
			'#required'=>true,
			'#attributes'=>array(
				'placeholder'=>'Name'
			)
		);

		$form['gender'] = array(
			'#type'=>'select',
			'#title'=>$this->t('Gender'),
			'#options'=>$genderOption,
			'#required'=>true
		);

		$form['about_employee'] = array(
			'#type'=>'textarea',
			'#title'=>$this->t('About Employee'),
			'#default_value'=>'',
			'#required'=>true,
			'#attributes'=>array(
				'placeholder'=>'About Employee'
			)
		);

		$form['save'] = array(
			'#type'=>'submit',
			'#title'=>$this->t('Save Employee'),
			'#default_value'=>'save',
			'#required'=>true
		);

		return $form;
	}
    
    /** 
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state){
    	// if(trim($form_state->getValue('name'))==''){
    	// 	$form_state->setErrorByName('name', $this->t('Name Field is required'));
    	// }else if($form_state->getValue('gender')==0){
    	// 	$form_state->setErrorByName('gender', $this->t('Gender Field is required'));
    	// }else if($form_state->getValue('about_employee')==''){
    	// 	$form_state->setErrorByName('about_employee', $this->t('About Employee Field is required'));
    	// }
    }

    /** 
     * {@inheritdoc}
     */
	public function submitForm(array &$form, FormStateInterface $form_state){
		$postData = $form_state->getValues();

		/**
		 * Remove Unwanted Keys from postData
		 */

		unset($postData['save'],$postData['form_build_id'],$postData['form_id'],$postData['form_token'],$postData['op']);
		
		$query = \Drupal::database();
		$query->insert('employees')->fields($postData)->execute();

		\Drupal::messenger()->addMessage(t('Employee data save successfully!'),'status',TRUE);
		// \Drupal::messenger()->addMessage(t('Employee data save successfully!'),'error',TRUE);
		// \Drupal::messenger()->addMessage(t('Employee data save successfully!'),'warning',TRUE);
		// \Drupal::messenger()->addMessage(t('Employee data save successfully!'),'info',TRUE);
	}
}