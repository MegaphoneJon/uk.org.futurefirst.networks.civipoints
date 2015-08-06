<?php
/*
 +--------------------------------------------------------------------+
 | CiviCRM version 4.4                                                |
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC (c) 2004-2013                                |
 +--------------------------------------------------------------------+
 | This file is a part of CiviCRM.                                    |
 |                                                                    |
 | CiviCRM is free software; you can copy, modify, and distribute it  |
 | under the terms of the GNU Affero General Public License           |
 | Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
 |                                                                    |
 | CiviCRM is distributed in the hope that it will be useful, but     |
 | WITHOUT ANY WARRANTY; without even the implied warranty of         |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
 | See the GNU Affero General Public License for more details.        |
 |                                                                    |
 | You should have received a copy of the GNU Affero General Public   |
 | License and the CiviCRM Licensing Exception along                  |
 | with this program; if not, contact CiviCRM LLC                     |
 | at info[AT]civicrm[DOT]org. If you have questions about the        |
 | GNU Affero General Public License or the licensing of CiviCRM,     |
 | see the CiviCRM license FAQ at http://civicrm.org/licensing        |
 +--------------------------------------------------------------------+
 */

/**
 *
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2013
 * $Id$
 *
 */

class CRM_Points_DAO_Points extends CRM_Core_DAO {
  /**
   * static instance to hold the table name
   *
   * @var string
   * @static
   */
  static $_tableName = 'civicrm_points';
  /**
   * static instance to hold the field values
   *
   * @var array
   * @static
   */
  static $_fields = NULL;
  /**
   * static instance to hold the FK relationships
   *
   * @var string
   * @static
   */
  static $_links = NULL;
  /**
   * static instance to hold the values that can
   * be imported
   *
   * @var array
   * @static
   */
  static $_import = NULL;
  /**
   * static instance to hold the values that can
   * be exported
   *
   * @var array
   * @static
   */
  static $_export = NULL;
  /**
   * static value to see if we should log any modifications to
   * this table in the civicrm_log table
   *
   * @var boolean
   * @static
   */
  static $_log = FALSE;

  /**
   * Unique Points ID
   *
   * @var int unsigned
   */
  public $id;
  /**
   * FK to Winning Contact
   *
   * @var int unsigned
   */
  public $contact_id;
  /**
   * FK to Granting Contact
   *
   * @var int unsigned
   */
  public $grantor_contact_id;
  /**
   * Number of points granted/removed
   *
   * @var int
   */
  public $points;
  /**
   * Points effective from this date inclusive
   *
   * @var date
   */
  public $start_date;
  /**
   * Points effective upto this date inclusive
   *
   * @var date
   */
  public $end_date;
  /**
   * Description
   *
   * @var string
   */
  public $description;
  /**
   * Points granted because of an entity of this type
   *
   * @var string
   */
  public $entity_table;
  /**
   * Points granted because of an entity with this ID
   *
   * @var int unsigned
   */
  public $entity_id;
  /**
   * Option value for the type of points being granted
   *
   * @var int unsigned
   */
  public $points_type_id;

  /**
   * class constructor
   *
   * @access public
   * @return CRM_Points_DAO_Points
   */
  function __construct() {
    parent::__construct();
  }

  /**
   * return foreign links
   *
   * @access public
   * @return array
   */
  function &links() {
    if (!(self::$_links)) {
      self::$_links = array(
        'contact_id'         => 'civicrm_contact:id',
        'grantor_contact_id' => 'civicrm_contact:id',
      );
    }
    return self::$_links;
  }

  /**
   * returns all the column names of this table
   *
   * @access public
   * @return array
   */
  static function &fields() {
    if (!(self::$_fields)) {
      self::$_fields = array(
          'id' => array(
            'name'     => 'id',
            'type'     => CRM_Utils_Type::T_INT,
            'title'    => ts('Unique Points ID'),
            'required' => TRUE,
          ),
          'contact_id' => array(
            'name'        => 'contact_id',
            'type'        => CRM_Utils_Type::T_INT,
            'title'       => ts('Winning Contact'),
            'required'    => TRUE,
            'FKClassName' => 'CRM_Contact_DAO_Contact',
          ),
          'grantor_contact_id' => array(
            'name'        => 'grantor_contact_id',
            'type'        => CRM_Utils_Type::T_INT,
            'title'       => ts('Granting Contact'),
            'FKClassName' => 'CRM_Contact_DAO_Contact',
          ),
          'points' => array(
            'name'     => 'points',
            'type'     => CRM_Utils_Type::T_INT,
            'title'    => ts('Points Granted/Removed'),
            'required' => TRUE,
          ),
          'start_date' => array(
            'name'     => 'start_date',
            'type'     => CRM_Utils_Type::T_DATE,
            'title'    => ts('Effective From'),
            'required' => TRUE,
            'default'  => date('Ymd'),
          ),
          'end_date' => array(
            'name'  => 'end_date',
            'type'  => CRM_Utils_Type::T_DATE,
            'title' => ts('Effective To'),
          ),
          'description' => array(
            'name'      => 'description',
            'type'      => CRM_Utils_Type::T_STRING,
            'title'     => ts('Description'),
            'maxlength' => 255,
            'size'      => CRM_Utils_Type::HUGE,
          ),
          'entity_table' => array(
            'name'      => 'entity_table',
            'type'      => CRM_Utils_Type::T_STRING,
            'title'     => ts('Refers to Entity Type'),
            'maxlength' => 64,
            'size'      => CRM_Utils_Type::HUGE,
          ),
          'entity_id' => array(
            'name'  => 'entity_id',
            'type'  => CRM_Utils_Type::T_INT,
            'title' => ts('Refers to Entity ID'),
          ),
          'points_type_id' => array(
            'name'      => 'points_type_id',
            'type'      => CRM_Utils_Type::T_STRING,
            'title'     => ts('Points Type'),
            'required'  => TRUE,
            'maxlength' => 512,
            'size'      => CRM_Utils_Type::HUGE,
            'pseudoconstant' => array(
              'optionGroupName' => 'points_type',
            ),
          ),
       );
    }
    return self::$_fields;
  }

  /**
   * returns the names of this table
   *
   * @access public
   * @return string
   */
  static function getTableName() {
    return CRM_Core_DAO::getLocaleTableName(self::$_tableName);
  }

  /**
   * returns if this table needs to be logged
   *
   * @access public
   * @return boolean
   */
  function getLog() {
    return self::$_log;
  }

  /**
   * returns the list of fields that can be imported
   *
   * @access public
   * return array
   */
  function &import($prefix = false) {
    if (!(self::$_import)) {
      self::$_import = array();
      $fields = self::fields();
      foreach($fields as $name => $field) {
        if (CRM_Utils_Array::value('import', $field)) {
          if ($prefix) {
            self::$_import['points'] = & $fields[$name];
          }
          else {
            self::$_import[$name] = & $fields[$name];
          }
        }
      }
    }
    return self::$_import;
  }

  /**
   * returns the list of fields that can be exported
   *
   * @access public
   * return array
   */
  function &export($prefix = false) {
    if (!(self::$_export)) {
      self::$_export = array();
      $fields = self::fields();
      foreach($fields as $name => $field) {
        if (CRM_Utils_Array::value('export', $field)) {
          if ($prefix) {
            self::$_export['points'] = & $fields[$name];
          }
          else {
            self::$_export[$name] = & $fields[$name];
          }
        }
      }
    }
    return self::$_export;
  }
}
