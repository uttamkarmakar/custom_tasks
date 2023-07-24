<?php

  namespace Drupal\color_field\Plugin\Field\FieldType;

  use Drupal\Core\Field\FieldItemBase;
  use Drupal\Core\Field\FieldStorageDefinitionInterface;
  use Drupal\Core\TypedData\DataDefinition;

  /**
   * Plugin Implementation of color_field
   * 
   * @FieldType(
   * 
   *  id = "custom_field",
   *  label = @Translation("Custom RGB Color"),
   *  description = @Translation("Field Type for storing custom color"),
   *  category = @Translation("Custom"),
   *  default_widget = "hex_color_widget",
   *  default_formatter = "custom_color_formatter",
   *  )
   */

  class CustomField extends FieldItemBase
  {

    public static function schema(FieldStorageDefinitionInterface $field_definition)
    {
      $columns = [];

      $columns['hex_code'] = [
        'type' => 'varchar',
        'length' => 7,
      ];

      $columns['r'] = [
        'type' => 'int',
        'length' => 'tiny',
      ];

      $columns['g'] = [
        'type' => 'int',
        'length' => 'tiny',
      ];

      $columns['b'] = [
        'type' => 'int',
        'length' => 'tiny',
      ];

      return [
        'columns' => $columns,
      ];
    }
    

    public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition)
    {
      $properties = [];
    
      $properties['hex_code'] = DataDefinition::create('string')
        ->setLabel("Hex Value")
        ->setRequired(FALSE); // Allow NULL values for hex_code.
    
      $properties['r'] = DataDefinition::create('integer')
        ->setLabel('Red')  
        ->setRequired(FALSE); // Allow NULL values for r.
    
      $properties['g']  = DataDefinition::create('integer')
        ->setLabel('Green')
        ->setRequired(FALSE); // Allow NULL values for g.
    
      $properties['b']  = DataDefinition::create('integer')
        ->setLabel('blue')
        ->setRequired(FALSE); // Allow NULL values for b.
  
      return $properties;
    }
    
  }
