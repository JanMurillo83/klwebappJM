TABLE exchange_rates {
    id BIGINT [pk, increment]
    exchange_rate DECIMAL(10, 6) //-- Tipo de cambio (puedes ajustar la precisión si es necesario)
    effective_date DATE //-- Fecha en la que el tipo de cambio es efectivo
    created_at TIMESTAMP
    updated_at TIMESTAMP 
}

TABLE services { // tabla general de servicios
  // Datos customer
  id BIGINT [pk, increment]
  exchange_rate_id BIGINT [ref: > exchange_rates.id]
  user_id BIGINT [ref: > users.id]
  business_directory_id BIGINT [ref: > business_directories.id]
  rate_to_customer DECIMAL
  currency ENUM('USD', 'MXN')
  billing_customer_reference VARCHAR(7)
  pickup_number VARCHAR
  shipment_status BIGINT [ref: > shipment_status.id]
  // Informacion del servicio
  id_service_detail BIGINT [ref: > service_details.id] // nombre del servicio FTL LTL ETC.
  expedited BOOLEAN
  hazmat BOOLEAN
  team_driver BOOLEAN
  round_trip BOOLEAN
  un_number VARCHAR(20)
  urgency_ltl_id BIGINT [ref: > urgency_ltl.id]
  modality_id BIGINT [ref: > modality.id]
  // tipo de carga
  cargo_id BIGINT [ref: > cargo.id]
  // pie
  manual_status TEXT
  time_status TIMESTAMP
  eta_delivery_status DATE
  notes_status VARCHAR
  created_at TIMESTAMP
  updated_at TIMESTAMP
  sub_services VARCHAR(255) //solo aplica para FTL Domestic USA, Domestic MX, door to door import, door to door export
}

Table collections {  
  id BIGINT [pk, increment]             // Identificador único de la colección
  service_id BIGINT [ref: > services.id] // Relación con la tabla de servicios
  total_shipping_cost DECIMAL(10, 2)     // Costo total del envío
  exchange_rate DECIMAL(10, 4)           // Tipo de cambio aplicado
  freight_charges DECIMAL(10, 2)         // Cargos por flete
  accessory_charges DECIMAL(10, 2)       // Cargos accesorios
  total_kronos_invoice DECIMAL(10, 2)    // Total de la factura de Kronos
  gross_profit DECIMAL(10, 2)            // Ganancia bruta
  commission DECIMAL(10, 2)              // Comisión
  net_profit DECIMAL(10, 2)              // Ganancia neta
  kronos_invoice_number VARCHAR(255)     // Número de factura Kronos
  sat_kronos_invoice_number VARCHAR(255) // Número de factura SAT de Kronos
  invoice_sent ENUM('yes', 'no')         // Si la factura fue enviada
  invoice_sent_date DATE                 // Fecha de envío de la factura
  kronos_invoice_due_date DATE           // Fecha de vencimiento de la factura de Kronos
  number_of_days_overdue DECIMAL(5, 2)   // Días de retraso en el pago
  payment_status ENUM('paid', 'pending', 'na') // Estado del pago
  payment_date DATE                      // Fecha de pago
  payment_addendum_attached BOOLEAN      // Si el anexo de pago está adjunto
  payment_sent ENUM('yes', 'no')         // Si el pago fue enviado
  created_at TIMESTAMP                   // Fecha de creación
  updated_at TIMESTAMP                   // Fecha de última actualización
}


Table urgency_ltl {
  id BIGINT [pk, increment]
  type BIGINT [ref: > urgency_types.id] 
  emergency_company VARCHAR (50)
  company_ID VARCHAR (50)
  phone VARCHAR(15)
}

Table modality {
  id BIGINT [pk, increment]
  type ENUM('SINGLE', 'FULL')
  container VARCHAR (50)
  size INT
  weight INT
  uom BIGINT [ref: > uoms.id]
  material_type BIGINT [ref: > material_types.id]
}

Table cargo {
  id BIGINT [pk, increment]
  handling_type BIGINT [ref: > handling_types.id]
  material_type BIGINT [ref: > material_types.id]
  class BIGINT [ref: > freight_classes.id]
  count INT
  stackable BOOLEAN // yes / No
  weight DECIMAL
  uom_weight BIGINT [ref: > uoms.id]
  length DECIMAL
  width DECIMAL
  height DECIMAL
  uom_dimensions BIGINT [ref: > uoms.id]
  total_yards DECIMAL
}

// Tabla de documentos para agregar la URL de drive
Table documents {
    id BIGINT [pk, increment]
    service_id BIGINT [ref: > services.id]
    document_url TEXT
    created_at TIMESTAMP
    updated_at TIMESTAMP
}

Table charges {
    id BIGINT [pk, increment]
    carrier_id BIGINT [ref: > carriers.id]              // Relación con transportista
    charge_type_id BIGINT [ref: > charge_types.id]       // Relación con el tipo de cargo
    description TEXT                                     // Descripción general del cargo
    cost DECIMAL(10, 2)                                  // Costo del cargo
    currency ENUM('USD', 'MXN')                          // Moneda
    iva DECIMAL(10, 2)                                   // IVA aplicado
    ret DECIMAL(10, 2)                                   // Retención aplicada
    discount DECIMAL(10, 2)                              // Descuento (solo si aplica)
    discount_description TEXT                            // Descripción del descuento
    claim_number VARCHAR(255)                            // Número de reclamo (si aplica)
    claim_status ENUM('recovered', 'rejected', 'under revision')  // Estado del reclamo
    recovered_amount DECIMAL(10, 2)                      // Monto recuperado (si el reclamo es recuperado)
    broker_name VARCHAR(255)                             // Nombre del broker (si aplica a Bonded)
    bond_number VARCHAR(255)                             // Número de bond (si aplica a Bonded)
    additional_info TEXT                                 // Información adicional (por ejemplo, para "Other Expenses")
    created_at TIMESTAMP
    updated_at TIMESTAMP
}

Table charge_types {
    id BIGINT [pk, increment]
    name VARCHAR(20) // Detention at Shipper , Detention at Consignee, Detention at Broker, Layover at Shipper, Layover at Broker, Layover at Customs, Layover at Consignee, Over Weight, Over Dimensions, Returning Back to the Shipper, TONU, Red Light at Customs, Pickup Address Change, Delivery Adress Change, Other
    description VARCHAR(50)
    created_at TIMESTAMP
    updated_at TIMESTAMP
}

// Tabla de shippers
Table shippers {
    id BIGINT [pk, increment]
    service_id BIGINT [ref: > services.id]
    requested_pickup_date DATE
    time TIME
    scheduled_border_crossing_date DATE
    drop_reception_date DATE //especificamente para trailer rental y warehouse
    created_at TIMESTAMP
    updated_at TIMESTAMP
}

// Tabla de consignees
Table consignees {
    id BIGINT [pk, increment]
    service_id BIGINT [ref: > services.id]
    delivery_date_requested DATE
    delivery_time_requested TIME
    actual_delivery_date DATE // Especificamente para Container Drayage
    actual_time TIME // Especificamente para Container Drayage
    withdrawal_date DATE // Especificamente para trailer rental y warehouse
    created_at TIMESTAMP
    updated_at TIMESTAMP
}

// Tabla de paradas (stop offs)
Table stop_offs {
    id BIGINT [pk, increment]
    service_id BIGINT [ref: > services.id]
    role ENUM('shipper', 'consignee')
    business_directory_id BIGINT [ref: > business_directories.id]
    position INT // Campo para manejar el orden
    created_at TIMESTAMP
    updated_at TIMESTAMP
}



// tabla para ver los costos de freight rate
Table cost_details {
    id BIGINT [pk, increment]
    freight_rate DECIMAL(10, 2)
    currency ENUM('USD', 'MXN')
    iva DECIMAL(10, 2)
    ret DECIMAL(10, 2)
    gps_link VARCHAR(255)
    created_at TIMESTAMP
    updated_at TIMESTAMP
}

// Tabla de detalles de recogida
Table pickup_details {
    id BIGINT [pk, increment]
    real_pickup_date DATE
    in_time TIME
    out_time TIME
    detention_hours DECIMAL(5, 2)
    created_at TIMESTAMP
    updated_at TIMESTAMP
}

// Tabla de detalles de entrega
Table delivery_details {
    id BIGINT [pk, increment]
    real_delivery_date DATE
    delivery_in_time TIME
    delivery_out_time TIME
    delivery_detention_hours DECIMAL(5, 2)
    created_at TIMESTAMP
    updated_at TIMESTAMP
}

Table equipment_details {
  id BIGINT [pk, increment]
  equipment VARCHAR // enlazar con los equipos del proveedor que se selecciono en la carrera
  truck_number VARCHAR
  truck_plates VARCHAR
  trailer_number VARCHAR
  trailer_plates VARCHAR
}

Table hand_carrier_details {
  id BIGINT [pk, increment]
  passaenger_name VARCHAR
  passaport_number VARCHAR
  passanger_id_number VARCHAR
  flight_number VARCHAR
  departure_date DATE
  departure_time time
  arrival_date DATE
  arrival_time time
}

Table carriers {
  id BIGINT [pk, increment]
  service_id BIGINT [ref: > services.id] // Relaciona con la tabla services
  carrier_detail_id BIGINT [ref: > carrier_details.id]
  business_directory_id BIGINT [ref: > business_directories.id] // se usa en todos
  service_date DATE // se usa en: maneuvers, us customs broker 
  tracking_number VARCHAR // se usa en: us carrier, mx carrier, supplier LTL, supplier Container Drayage, charter, Air Freight
  cost_details_id BIGINT [ref: > cost_details.id]
  equipment_details_id BIGINT [ref: > equipment_details.id] // supplier LTL, us carrier, mx carrier, 
  gps_link VARCHAR // se usa en: us carrier, transfer, mx carrier, supplier LTL, supplier Container Drayage, supplier hand carrie, trailer rental, charter Air Freight
  port_of_entry INT // se usa en: transfer
  pickup_details_id BIGINT [ref: > pickup_details.id] 
  delivery_details_id BIGINT [ref: > delivery_details.id] 
  service_type_carrier_broker_id BIGINT [ref: > service_type_carrier_brokers.id] // Bond creation , Entry creation se usa en: us customs broker
  arrival_requested VARCHAR // se usa en: us customs broker
  cancelation_requested VARCHAR // se usa en: us customs broker
  hand_carrier_detail_id BIGINT [ref: >hand_carrier_details.id] // se usa en: supplier hand carrier
  trailer_rental_carrier_detail_id BIGINT [ref: > trailer_rental_carrier_details.id] 
  charter_carrier_detail_id BIGINT [ref: > charter_carrier_details.id]
  transfer_type ENUM('Esport, Import') // se usa en transfer
}

Table to_pay {
  id BIGINT [pk, increment]
  carriers BIGINT [ref: > carriers.id]
  supplier_invoice_amount DECIMAL(10, 2)
  supplier_invoice_number DECIMAL(10, 2)
  invoice_date DATE
  invoice_status ENUM('acepted, returned, rejected')
  invoice_status_notes VARCHAR 
  invoice_payment_status  ENUM('Pending, Paid, NA') 
  invoice_due_date DATE
  invoice_payment_date DATE
  payment_term ENUM('PPD, PUE')
  payment_complement_received ENUM('yes, no')
  attachments VARCHAR 
  advancement DECIMAL(10, 2)
  remanent  VARCHAR
}

Table service_type_carrier_brokers {
    id BIGINT [pk, increment]
    name VARCHAR(50) // Bond creation, Entry creation, 
    description VARCHAR(255)
    created_at TIMESTAMP
    updated_at TIMESTAMP
}

Table carrier_details {
  id BIGINT [pk, increment]
  name VARCHAR(50) // Especifica el tipo de carrera 'us carrier, us customs broker, transfer, maneuvers, mx carrier, supplier, etc'
  description VARCHAR 
  id_service_detail BIGINT [ref: > service_details.id]
  created_at TIMESTAMP
  updated_at TIMESTAMP
}

Table service_details {
  id BIGINT [pk, increment]
  name ENUM('FTL, LTL, hand carrier, charter, Air Freight, Container Drayage, warehouse, Trailer Rental, us customs broker, Transfer') // Especifica el tipo de carrera
  description VARCHAR 
  created_at TIMESTAMP
  updated_at TIMESTAMP
}

Table trailer_rental_carrier_details {
  id BIGINT [pk, increment]
  monthly_rate DECIMAL(10, 2)
  currency_monthly VARCHAR
  iva_monthly DECIMAL(10, 2)
  ret_monthly DECIMAL(10, 2)
  alocation_rate DECIMAL(10, 2)
  currency_alocation VARCHAR
  iva_alocation DECIMAL(10, 2)
  ret_alocation DECIMAL(10, 2)
}

Table charter_carrier_details {
  id BIGINT [pk, increment]
  pickup_date DATE
  delivery_date_requested DATE
  time TIME
  actual_delivery_time TIME
  flight_number INT
  tail_number INT
  departure_date DATE
  departure_time TIME
  arrival_date DATE
  arrival_time TIME
  cost_per_hour DECIMAL(10, 2)
}

// Tabla para definir datos - catalog
Table shipment_status {
    id BIGINT [pk, increment]
    name VARCHAR(20) // Completed, cancelled, Scheduled, Active, Quoting
    description VARCHAR(50)
    created_at TIMESTAMP
    updated_at TIMESTAMP
}
Table handling_types {
    id BIGINT [pk, increment]
    name VARCHAR(20) // Bag, Bale, Barrel, Basket, Box , Bucket, Bulkhead, Bundle , Carton, Case, Crate, Cylinder, Drum, Package, Pallet, Piece, Rack, Reel, Roll, Skid, Tote, Sheet, Tube
    description VARCHAR(50)
    created_at TIMESTAMP
    updated_at TIMESTAMP
}
Table material_types {
    id BIGINT [pk, increment]
    name VARCHAR(20) // Automotive fabric, Automotive foam, Automotive parts, Automotive vinyl, Electronic devices Sand printed cores, Hazmat Adhesives, Metal rack, Molds, Machine, Paint, Resin, Plastics automotive, Plasticos termoplasticos, Hazmat Material
    description VARCHAR(50)
    created_at TIMESTAMP
    updated_at TIMESTAMP
}
Table freight_classes {
    id BIGINT [pk, increment]
    name VARCHAR(20) // Class 55, Class 60, Class 65, Class 70, Class 70.5, Class 85, Class 92.5, Class 100, Class 110, Class 125, Class 150, Class 175, Class 200, Class 250, Class 300, Class 400, Class 500
    description VARCHAR(50)
    created_at TIMESTAMP
    updated_at TIMESTAMP
}

Table uoms {
    id BIGINT [pk, increment]
    name VARCHAR(20) // kg, lbs, in, ft
    description ENUM('Unidades de Peso','Unidades de Longitud', 'Unidades de Volumen') // Valores predefinidos para el uso
    created_at TIMESTAMP
    updated_at TIMESTAMP
}

Table urgency_types {
    id BIGINT [pk, increment]
    name VARCHAR(20) // Economy, Guaranteed Delivery
    description VARCHAR(20) //
    created_at TIMESTAMP
    updated_at TIMESTAMP
}

// DIRECTORIO 
Table business_directories {
  id BIGINT [pk, increment]                        // Identificador único de la entrada del directorio
  type ENUM('station', 'customer', 'supplier')     // Tipo de entrada (station, customer, supplier)
  company VARCHAR(255)                             // Nombre de la empresa
  nickname VARCHAR(255)                            // Apodo o nombre corto
  billing_currency ENUM('USD', 'MXN')              // Moneda de facturación
  rfc_tax_id VARCHAR(20)                           // RFC o ID de impuestos
  street_address VARCHAR(255)                      // Dirección de la calle
  building_number VARCHAR(20)                      // Número del edificio
  neighborhood VARCHAR(255)                        // Colonia o barrio
  city VARCHAR(255)                                // Ciudad
  state VARCHAR(255)                               // Estado
  postal_code VARCHAR(10)                          // Código postal
  country VARCHAR(255)                             // País
  phone VARCHAR(20)                                // Teléfono
  website VARCHAR(255)                             // Sitio web
  email VARCHAR(255)                               // Correo electrónico
  credit_days INT                                  // Días de crédito
  credit_expiration_date DATE                      // Fecha de expiración del crédito
  free_loading_unloading_hours INT                 // Horas de carga y descarga gratuita
  factory_company_id BIGINT [ref: > factory_companies.id]
  notes TEXT                                       // Notas adicionales
  add_document TEXT                                // Campo para agregar URL de documentos
  document_expiration_date DATE                    // Fecha de expiración del documento
  picture VARCHAR(255)                             // URL de la imagen o foto
  tarifario TEXT                                   // Tarifario
  created_at TIMESTAMP                             // Fecha de creación
  updated_at TIMESTAMP                             // Fecha de última actualización
}

Table factory_companies {
  id BIGINT [pk, increment]
  name varchar
  notes varchar
  created_at TIMESTAMP                             // Fecha de creación
  updated_at TIMESTAMP 
}

Table contacts {
  id BIGINT [pk, increment]                        // Identificador único del contacto
  directory_entry_id BIGINT [ref: > business_directories.id] // Relación con la tabla de entradas del directorio
  name VARCHAR(255)                                // Nombre del contacto
  last_name VARCHAR(255)                           // Apellido del contacto
  office_phone VARCHAR(20)                         // Teléfono de la oficina
  cellphone VARCHAR(20)                            // Teléfono móvil
  email VARCHAR(255)                               // Correo electrónico
  working_hours VARCHAR(50)                        // Horario laboral
  notes TEXT                                       // Notas adicionales
  created_at TIMESTAMP                             // Fecha de creación
  updated_at TIMESTAMP                             // Fecha de última actualización
}

Table suppliers {
  id BIGINT [pk, increment]                        // Identificador único del proveedor
  directory_entry_id BIGINT [ref: > business_directories.id] // Relación con la tabla de entradas del directorio
  mc_number VARCHAR(20)                            // Número MC
  usdot VARCHAR(20)                                // Número USDOT
  scac VARCHAR(20)                                 // Código SCAC
  caat VARCHAR(20)                                 // Código CAAT
  created_at TIMESTAMP                             // Fecha de creación
  updated_at TIMESTAMP                             // Fecha de última actualización
}

Table services_suppliers {
  id BIGINT [pk, increment]
  supplier_id BIGINT [ref: > suppliers.id]
  id_service_detail BIGINT [ref: > service_details.id]
}

Table supplier_equipments {
  id BIGINT [pk, increment]                        // Identificador único del equipo
  supplier_id BIGINT [ref: > suppliers.id]         // Relación con la tabla de proveedores
  equipment VARCHAR(255)                           // Nombre o tipo del equipo
  description TEXT                                 // Descripción del equipo
  created_at TIMESTAMP                             // Fecha de creación
  updated_at TIMESTAMP                             // Fecha de última actualización
}

Table tarifario {
  id BIGINT [pk, increment]                        // Identificador único del equipo
  supplier_id BIGINT [ref: > suppliers.id]         // Relación con la tabla de proveedores
  // equipment VARCHAR(255)                           // Nombre o tipo del equipo
  // description TEXT                                 // Descripción del equipo
  // created_at TIMESTAMP                             // Fecha de creación
  // updated_at TIMESTAMP                             // Fecha de última actualización
}

Table supplier_reviews {
  id BIGINT [pk, increment]                        // Identificador único de la reseña
  supplier_id BIGINT [ref: > suppliers.id]         // Relación con la tabla de proveedores
  calification INT                                 // Calificación del proveedor
  review TEXT                                      // Reseña del proveedor
  created_at TIMESTAMP                             // Fecha de creación
  updated_at TIMESTAMP                             // Fecha de última actualización
}


// Tabla de usuarios
Table users {
  id BIGINT [pk, increment]
  name VARCHAR(255)
  last_name VARCHAR(255)
  email VARCHAR(255) [unique]
  email_verified_at VARCHAR(255) [unique]
  password VARCHAR(255)
  two_factor_secret text
  two_factor_recovery_codes text
  two_factor_confirmed_at timestamp
  remember_token varchar(100)
  current_team_id bigint
  profile_photo_path varchar(2048)
  phone VARCHAR(20)
  job_title VARCHAR(255)
  office VARCHAR(255)
  birthday DATE
  created_at timestamp
  updated_at timestamp
}

// Tabla de permisos de usuario para módulos Spatie\Permission\Models\Role
Table model_has_roles {
  role_id BIGINT [ref: > roles.id]
  model_type varchar(255)
  model_id bigint
}

Table roles {
  id bigint
  name varchar(255)
  guard_name varchar(255)
  created_at timestamp
  updated_at timestamp
}

Table role_has_permissions {
  permission_id BIGINT [ref: > permissions.id]
  role_id BIGINT [ref: > roles.id]
}

Table permissions {
  id bigint
  name varchar(255)
  guard_name varchar(255)
  created_at timestamp
  updated_at timestamp
}

Table model_has_permissions {
  permisions_id BIGINT [ref: > permissions.id]
  model_type varchar(255)
  model_id varchar(255)
}

Table employees {
    id BIGINT [pk, increment]
    user_id BIGINT [ref: > users.id]              // Relación opcional con usuarios
    name VARCHAR(255)                             // Nombre del empleado
    last_name VARCHAR(255)                        // Apellido del empleado
    email VARCHAR(255) [unique]                   // Correo electrónico del empleado
    phone VARCHAR(20)                             // Teléfono
    job_title VARCHAR(255)                        // Título del puesto
    office VARCHAR(255)                           // Oficina
    birthday DATE                                 // Fecha de nacimiento
    date_of_hire DATE                             // Fecha de contratación
    address_id BIGINT [ref: > addresses.id]        // Relación con la tabla de direcciones
    NSS varchar                                   // Número de Seguridad Social
    tax_status_certificate varchar                // Certificado de estado fiscal
    id_ine varchar                                // INE (Identificación oficial)
    social_security_number varchar                // Número de seguro social
    proof_of_address varchar                      // Comprobante de domicilio
    created_at TIMESTAMP
    updated_at TIMESTAMP
}


Table addresses {
    id BIGINT [pk, increment]
    street_address varchar
    building_number number
    neighborhood varchar
    city varchar
    state varchar
    postal_code varchar
    country varchar
}

Table bank_details {
    id BIGINT [pk, increment]
    employee_id BIGINT [ref: > employees.id]
    bank_name varchar
    account_number varchar
    card_number varchar
    clabe varchar
}

Table devices {
    id BIGINT [pk, increment]
    employee_id BIGINT [ref: > employees.id]
    type varchar  // 'computer' o 'cellphone'
    brand varchar
    model varchar
    serial_number varchar
    color varchar
    charger_cable_recived BOOLEAN
}

Table emergency_contacts {
    id BIGINT [pk, increment]
    employee_id BIGINT [ref: > employees.id]
    name varchar
    relationship varchar
    phone varchar
}

Table work_schedule {
    id BIGINT [pk, increment]
    employee_id BIGINT [ref: > employees.id]
    day_of_week varchar  // 'monday', 'tuesday', etc.
    time_in TIME
    time_out TIME
}
