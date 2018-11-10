<?php

$config = array(
             	


             	


             	


             	


             	


             	


             	


             	


             	


             					

				'bankdetails' => array(array(
                                	'field'=>'accountname',
                                	'label'=>'Account Name',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'accountno',
                                	'label'=>'Account Number',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'bankname',
                                	'label'=>'Bank Name',
                                	'rules'=>'required|trim|xss_clean'
                                ))
			   
			   
				,

				'organizationdetails' => array(array(
                                	'field'=>'organizationname',
                                	'label'=>'Organization Name',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'address',
                                	'label'=>'Address',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'postalcode',
                                	'label'=>'Postal Code',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'telephone',
                                	'label'=>'Telephone',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'fax',
                                	'label'=>'Fax',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'email',
                                	'label'=>'Email',
                                	'rules'=>'required|trim|valid_email|xss_clean'
                                ),
								array(
                                	'field'=>'website',
                                	'label'=>'Website',
                                	'rules'=>'required|trim|xss_clean'
                                ))
			   
			   
				,

				'programmes' => array(array(
                                	'field'=>'programname',
                                	'label'=>'Program Name',
                                	'rules'=>'required|trim|xss_clean'
                                ))
			   
			   
				,

				'courses' => array(array(
                                	'field'=>'code',
                                	'label'=>'Code',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'coursetitle',
                                	'label'=>'Course Title',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'meantfor',
                                	'label'=>'Meant for',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'coursedetail',
                                	'label'=>'Course Detail',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'program_id',
                                	'label'=>'Program',
                                	'rules'=>'required|trim|xss_clean'
                                ))
			   
			   
				,

				'courseplans' => array(array(
                                	'field'=>'course_id',
                                	'label'=>'Course',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'residentialcost',
                                	'label'=>'Residential Cost',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'nonresidentialcost',
                                	'label'=>'Non-residential Cost',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'foreignresidentialcost',
                                	'label'=>'Foreigner Residential Cost',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'foreignnonresidentialcost',
                                	'label'=>'Foreigner Non-residential Cost',
                                	'rules'=>'required|trim|xss_clean'
                                ))
			   
			   
				,

				'taxinfo' => array(array(
                                	'field'=>'vatno',
                                	'label'=>'Vat No',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'pinno',
                                	'label'=>'Pin No',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'vatpercent',
                                	'label'=>'Vat Percentage',
                                	'rules'=>'required|trim|xss_clean'
                                ))
			   
			   
				,

				'accounts' => array(array(
                                	'field'=>'code',
                                	'label'=>'Code',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'accontname',
                                	'label'=>'Accont Name',
                                	'rules'=>'required|trim|xss_clean'
                                ))
			   
			   
				,

				'invoices' => array(array(
                                	'field'=>'fullname',
                                	'label'=>'Fullname',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'telephone',
                                	'label'=>'Telephone',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'mobile',
                                	'label'=>'Mobile',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'ministry',
                                	'label'=>'Ministry',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'department',
                                	'label'=>'Department',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'email',
                                	'label'=>'Email',
                                	'rules'=>'required|trim|valid_email|xss_clean'
                                ),
								array(
                                	'field'=>'issuedate',
                                	'label'=>'Issuedate',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'validuntil',
                                	'label'=>'Validuntil',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'issuedby',
                                	'label'=>'Issuedby',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'account_id',
                                	'label'=>'Account_id',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'status',
                                	'label'=>'Status',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'process',
                                	'label'=>'Process',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'trackingcode',
                                	'label'=>'Trackingcode',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'dateadded',
                                	'label'=>'Dateadded',
                                	'rules'=>'required|trim|xss_clean'
                                ))
			   
			   
				,

				'products' => array(array(
                                	'field'=>'name',
                                	'label'=>'Name',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'description',
                                	'label'=>'Description',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'imagename',
                                	'label'=>'Imagename',
                                	'rules'=>'trim|xss_clean'
                                ),
								array(
                                	'field'=>'imagetype',
                                	'label'=>'Imagetype',
                                	'rules'=>'trim|xss_clean'
                                ),
								array(
                                	'field'=>'imagesize',
                                	'label'=>'Imagesize',
                                	'rules'=>'trim|xss_clean'
                                ),
								array(
                                	'field'=>'wholesaleprice',
                                	'label'=>'Wholesaleprice',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'retailprice',
                                	'label'=>'Retailprice',
                                	'rules'=>'required|trim|xss_clean'
                                ))
			   
			   
				,

				'sales' => array(array(
                                	'field'=>'user_id',
                                	'label'=>'User_id',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'salestype',
                                	'label'=>'Salestype',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'saledate',
                                	'label'=>'Saledate',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'salecompleted',
                                	'label'=>'Salecompleted',
                                	'rules'=>'required|trim|xss_clean'
                                ))
			   );
			   
?>