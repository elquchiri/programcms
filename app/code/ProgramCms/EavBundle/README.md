The EAV bundle contains common infrastructure that provides an ability to apply EAV Model features in ProgramCMS application.

## Entity Type
To Create an EAV Entity Type, please fill to targeted entity classes like bellow :
```bash
  entity_type_id | entity_type_code                        | additional_attribute_table
  1              | ProgramCms\UserBundle\Entity\UserEntity | ProgramCms\UserBundle\Entity\UserEavAttribute
```