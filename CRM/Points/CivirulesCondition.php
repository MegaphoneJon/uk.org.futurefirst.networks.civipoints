<?php

/**
 * Class for CiviRules condition of CiviPoints received
 */
class CRM_Points_CivirulesCondition extends CRM_CivirulesConditions_Generic_ValueComparison {
  /**
   * Returns the number of points the contact has
   *
   * TODO: Only checks points as at the time of the check,
   * only checks the default points type
   *
   * @param CRM_Civirules_TriggerData_TriggerData $triggerData
   * @return boolean|int FALSE on error, or an integer sum of points in effect
   */
  protected function getFieldValue(CRM_Civirules_TriggerData_TriggerData $triggerData) {
    $cid = $triggerData->getContactId();
    $points_type_id = civicrm_api('OptionValue', 'getvalue', array(
      'version'           => 3,
      'option_group_name' => 'points_type',
      'is_default'        => 1,
      'return'            => 'value',
    ));

    $points = civicrm_api('Points', 'getsum', array(
      'version'        => 3,
      'contact_id'     => $cid,
      'points_type_id' => $points_type_id,
    ));

    if (civicrm_error($points)) {
      return FALSE;
    }
    elseif (empty($points)) {
      // As we may get NULL if the contact has no points grants in effect
      return 0;
    }
    else {
      return $points;
    }
  }

  /**
   * Returns user-friendly text explaining the condition for the
   * 'CiviRules Update Rule' screen,
   * eg. 'Contact has at least 5 points' rather than '>= 5'
   *
   * @return string
   */
  public function userFriendlyConditionParams() {
    switch ($this->getOperator()) {
      case '=':
        $label = 'Contact has exactly %1 points';
        break;
      case '>':
        $label = 'Contact has more than %1 points';
        break;
      case '<':
        $label = 'Contact has less than %1 points';
        break;
      case '>=':
        $label = 'Contact has at least %1 points';
        break;
      case '<=':
        $label = 'Contact has at most %1 points';
        break;
      case '!=':
        $label = 'Contact does not have exactly %1 points';
        break;
      default:
        return '';
    }
    return ts($label, array(1 => $this->getComparisonValue()));
  }

  /**
   * Returns a list of available comparison operators and explanations,
   * for the 'CiviRules Edit Condition parameters' screen.
   *
   * @return array
   */
  public function getOperators() {
    return array(
      '='  => ts('Exactly this many points'),
      '!=' => ts('Not this many points'),
      '>'  => ts('More than this many points'),
      '<'  => ts('Less than this many points'),
      '>=' => ts('At least this many points'),
      '<=' => ts('At most this many points'),
    );
  }
}
