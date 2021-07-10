<?php 
function cloudVendorDefaultAssessment($postId=0)
{
    $opts = [
        'display_name' => 'Cloud Vendor Default',
        'desc' => '',
        'areas' => [
            '1' => ['name' => 'Vendor A', 'base' => '1'],
            '2' => ['name' => 'Vendor B', 'base' => '2'],
            '3' => ['name' => 'Vendor C', 'base' => '3'],
            '4' => ['name' => 'Vendor D', 'base' => '4'],
        ],
        'area_1_threatcat' => [
            '1' => ['name' => 'Governance', 'desc' => ''],
            '2' => ['name' => 'Operations', 'desc' => ''],
            '3' => ['name' => 'Security & Risk Management', 'desc' => ''], 
            '4' => ['name' => 'People & Processes', 'desc' => ''],
        ],
        'area_2_threatcat' => [
            '1' => ['name' => 'Governance', 'desc' => ''],
            '2' => ['name' => 'Operations', 'desc' => ''],
            '3' => ['name' => 'Security & Risk Management', 'desc' => ''], 
            '4' => ['name' => 'People & Processes', 'desc' => ''],
        ],
        'area_3_threatcat' => [
            '1' => ['name' => 'Governance', 'desc' => ''],
            '2' => ['name' => 'Operations', 'desc' => ''],
            '3' => ['name' => 'Security & Risk Management', 'desc' => ''], 
            '4' => ['name' => 'People & Processes', 'desc' => ''],
        ],
        'area_4_threatcat' => [
            '1' => ['name' => 'Governance', 'desc' => ''],
            '2' => ['name' => 'Operations', 'desc' => ''],
            '3' => ['name' => 'Security & Risk Management', 'desc' => ''], 
            '4' => ['name' => 'People & Processes', 'desc' => ''],
        ],
        'area_1_threatcat_1_threat' => [
            '1' => ['name' => 'Application & Interface Security', 'desc' => ''],
            '2' => ['name' => 'Audit Assurance & Compliance', 'desc' => ''],
            '3' => ['name' => 'Business Continuity Management & Operational Resilience', 'desc' => ''],
            '4' => ['name' => 'Change Control & Configuration Management', 'desc' => ''],
            '5' => ['name' => 'Data Security & Information Lifecycle Management', 'desc' => ''],
            '6' => ['name' => 'Datacenter Security', 'desc' => ''],
            '7' => ['name' => 'Encryption & Key Management', 'desc' => ''],
            '8' => ['name' => 'Governance & Risk Management', 'desc' => ''],
            '9' => ['name' => 'Human Resources', 'desc' => ''],
            '10' => ['name' => 'Identity & Access Management', 'desc' => ''],
            '11' => ['name' => 'Infrastructure & Virtualization Security', 'desc' => ''],
            '12' => ['name' => 'Interoperability & Portability', 'desc' => ''],
            '13' => ['name' => 'Mobile Security', 'desc' => ''],
            '14' => ['name' => 'Security Incident Management, e-Discovery, & Cloud Forensics', 'desc' => ''],
            '15' => ['name' => 'Supply Chain Management, Transparency, and Accountability', 'desc' => ''],
            '16' => ['name' => 'Threat and Vulnerability Management', 'desc' => ''],
        ],
        'area_1_threatcat_2_threat' => [
            '1' => ['name' => 'Operations Security 01'],
            '2' => ['name' => 'Operations Security 02'],
        ],
        'area_1_threatcat_3_threat' => [
            '1' => ['name' => 'Security & Risk Management statement 1'],
        ],
        'area_1_threatcat_4_threat' => [
            '1' => ['name' => 'People & Processes statement 1'],
        ],
        'area_2_threatcat_1_threat' => [
            '1' => ['name' => 'Budget Risk Threat cat 1 statement 1'],
        ],
        'area_3_threatcat_1_threat' => [
            '1' => ['name' => 'Milestone Threat cat 1 statement 1'],
        ],

        'area_1_threatcat_1_threat_1_question' => [
            '1' => ['name' => 'Application Security', 'desc' => ''],
            '2' => ['name' => 'Customer Access Requirements', 'desc' => ''],
            '3' => ['name' => 'Data Integrity', 'desc' => ''],
            '4' => ['name' => 'Data Security/Integrity', 'desc' => ''],
        ],
        'area_1_threatcat_1_threat_2_question' => [
            '1' => ['name' => 'Audit Planning', 'desc' => ''],
            '2' => ['name' => 'Independent Audits', 'desc' => ''],
            '3' => ['name' => 'Information System Regulatory Mapping', 'desc' => ''],
        ],
        'area_1_threatcat_1_threat_3_question' => [
            '1' => ['name' => 'Business Continuity Planning', 'desc' => ''],
            '2' => ['name' => 'Business Continuity Testing', 'desc' => ''],
            '3' => ['name' => 'Power/Telecommunications', 'desc' => ''],
            '4' => ['name' => 'Resilience Documentation', 'desc' => ''],
            '5' => ['name' => 'Environmental Risks', 'desc' => ''],
            '6' => ['name' => 'Equipment Location', 'desc' => ''],
            '7' => ['name' => 'Equipment Maintenance', 'desc' => ''],
            '8' => ['name' => 'Equipment Power Failures', 'desc' => ''],
            '9' => ['name' => 'Impact Analysis', 'desc' => ''],
            '10' => ['name' => 'Policy', 'desc' => ''],
            '11' => ['name' => 'Retention Policy', 'desc' => ''],
        ],
        'area_1_threatcat_1_threat_4_question' => [
            '1' => ['name' => 'New Development/Acquisition', 'desc' => ''],
            '2' => ['name' => 'Outsourced Development', 'desc' => ''],
            '3' => ['name' => 'Management Quality Testing', 'desc' => ''],
            '4' => ['name' => 'Unauthorized Software Installations', 'desc' => ''],
            '5' => ['name' => 'Production Changes', 'desc' => ''],
        ],
        'area_1_threatcat_1_threat_5_question' => [
            '1' => ['name' => 'Data Inventory/Flows', 'desc' => ''],
            '2' => ['name' => 'E-commerce Transactions', 'desc' => ''],
            '3' => ['name' => 'Handling/Labeling/Security Policy', 'desc' => ''],
            '4' => ['name' => 'Nonproduction Data', 'desc' => ''],
            '5' => ['name' => 'Ownership/Stewardship', 'desc' => ''],
            '6' => ['name' => 'Secure Disposal', 'desc' => ''],
        ],
        'area_1_threatcat_1_threat_6_question' => [
            '1' => ['name' => 'Asset Management', 'desc' => ''],
            '2' => ['name' => 'Controlled Access Points', 'desc' => ''],
            '3' => ['name' => 'Equipment Identification', 'desc' => ''],
            '4' => ['name' => 'Offsite Authorization', 'desc' => ''],
            '5' => ['name' => 'Offsite Equipment', 'desc' => ''],
            '6' => ['name' => 'Policy', 'desc' => ''],
            '7' => ['name' => 'Secure Area Authorization', 'desc' => ''],
            '8' => ['name' => 'Unauthorized Persons Entry', 'desc' => ''],
            '9' => ['name' => 'User Access', 'desc' => ''],
        ],
        'area_1_threatcat_1_threat_7_question' => [
            '1' => ['name' => 'Entitlement', 'desc' => ''],
            '2' => ['name' => 'Key Generation', 'desc' => ''],
            '3' => ['name' => 'Encryption', 'desc' => ''],
            '4' => ['name' => 'Storage and Access', 'desc' => ''],
        ],
        'area_1_threatcat_1_threat_8_question' => [
            '1' => ['name' => 'Baseline Requirements', 'desc' => ''],
            '2' => ['name' => 'Risk Assessments', 'desc' => ''],
            '3' => ['name' => 'Management Oversight', 'desc' => ''],
            '4' => ['name' => 'Management Program', 'desc' => ''],
            '5' => ['name' => 'Management Support/Involvement', 'desc' => ''],
            '6' => ['name' => 'Policy', 'desc' => ''],
            '7' => ['name' => 'Policy Enforcement', 'desc' => ''],
            '8' => ['name' => 'Business/Policy Change Impacts', 'desc' => ''],
            '9' => ['name' => 'Policy Reviews', 'desc' => ''],
            '10' => ['name' => 'Assessments', 'desc' => ''],
            '11' => ['name' => 'Program', 'desc' => ''],
        ],
        'area_1_threatcat_1_threat_9_question' => [
            '1' => ['name' => 'Asset Returns', 'desc' => ''],
            '2' => ['name' => 'Background Screening', 'desc' => ''],
            '3' => ['name' => 'Employment Agreements', 'desc' => ''],
            '4' => ['name' => 'Employment Termination', 'desc' => ''],
            '5' => ['name' => 'Portable/Mobile Devices', 'desc' => ''],
            '6' => ['name' => 'Non-Disclosure Agreements', 'desc' => ''],
            '7' => ['name' => 'Roles/Responsibilities', 'desc' => ''],
            '8' => ['name' => 'Acceptable Use', 'desc' => ''],
            '9' => ['name' => 'Training/Awareness', 'desc' => ''],
            '10' => ['name' => 'User Responsibility', 'desc' => ''],
            '11' => ['name' => 'Workspace', 'desc' => ''],
        ],
        'area_1_threatcat_1_threat_10_question' => [
            '1' => ['name' => 'Audit Tools Access', 'desc' => ''],
            '2' => ['name' => 'User Access Policy', 'desc' => ''],
            '3' => ['name' => 'Diagnostic/Configuration Ports Access', 'desc' => ''],
            '4' => ['name' => 'Policies and Procedures', 'desc' => ''],
            '5' => ['name' => 'Segregation of Duties', 'desc' => ''],
            '6' => ['name' => 'Source Code Access Restriction', 'desc' => ''],
            '7' => ['name' => 'Third Party Access', 'desc' => ''],
            '8' => ['name' => 'User Access Restriction/Authorization', 'desc' => ''],
            '9' => ['name' => 'User Access Authorization', 'desc' => ''],
            '10' => ['name' => 'User Access Reviews', 'desc' => ''],
            '11' => ['name' => 'User Access Revocation', 'desc' => ''],
            '12' => ['name' => 'User ID Credentials', 'desc' => ''],
            '13' => ['name' => 'Utility Programs Access', 'desc' => ''],
        ],
        'area_1_threatcat_1_threat_11_question' => [
            '1' => ['name' => 'Audit Logging/Intrusion Detection', 'desc' => ''],
            '2' => ['name' => 'Change Detection', 'desc' => ''],
            '3' => ['name' => 'Clock Synchronization', 'desc' => ''],
            '4' => ['name' => 'Capacity/Resource Planning', 'desc' => ''],
            '5' => ['name' => 'Vulnerability Management', 'desc' => ''],
            '6' => ['name' => 'Network Security', 'desc' => ''],
            '7' => ['name' => 'OS Hardening and Base Controls', 'desc' => ''],
            '8' => ['name' => 'Production/Non-Production Environments', 'desc' => ''],
            '9' => ['name' => 'Segmentation', 'desc' => ''],
            '10' => ['name' => 'VM Security - Data', 'desc' => ''],
            '11' => ['name' => 'VMM Security - Hypervisor Hardening', 'desc' => ''],
            '12' => ['name' => 'Network Architecture', 'desc' => ''],
        ],
        'area_1_threatcat_1_threat_12_question' => [
            '1' => ['name' => 'APIs', 'desc' => ''],
            '2' => ['name' => 'Data Request', 'desc' => ''],
            '3' => ['name' => 'Policy & Legal', 'desc' => ''],
            '4' => ['name' => 'Standardized Network Protocols', 'desc' => ''],
            '5' => ['name' => 'Virtualization', 'desc' => ''],
        ],
        'area_1_threatcat_1_threat_13_question' => [
            '1' => ['name' => 'Anti-Malware', 'desc' => ''],
            '2' => ['name' => 'Application Stores', 'desc' => ''],
            '3' => ['name' => 'Approved Applications', 'desc' => ''],
            '4' => ['name' => 'Approved Software for BYOD', 'desc' => ''],
            '5' => ['name' => 'Awareness & Training', 'desc' => ''],
            '6' => ['name' => 'Cloud Based Services', 'desc' => ''],
            '7' => ['name' => 'Compatibility', 'desc' => ''],
            '8' => ['name' => 'Device Eligibility', 'desc' => ''],
            '9' => ['name' => 'Device Inventory', 'desc' => ''],
            '10' => ['name' => 'Device Management', 'desc' => ''],
            '11' => ['name' => 'Encryption', 'desc' => ''],
            '12' => ['name' => 'Jailbreaking & Rooting', 'desc' => ''],
            '13' => ['name' => 'Legal', 'desc' => ''],
            '14' => ['name' => 'Lockout Screen', 'desc' => ''],
            '15' => ['name' => 'Operating Systems', 'desc' => ''],
            '16' => ['name' => 'Passwords', 'desc' => ''],
            '17' => ['name' => 'Policy', 'desc' => ''],
            '18' => ['name' => 'Remote Wipe', 'desc' => ''],
            '19' => ['name' => 'Security Patches', 'desc' => ''],
            '20' => ['name' => 'Users', 'desc' => ''],
        ],
        'area_1_threatcat_1_threat_14_question' => [
            '1' => ['name' => 'Contact/Authority Maintenance', 'desc' => ''],
            '2' => ['name' => 'Incident Management', 'desc' => ''],
            '3' => ['name' => 'Incident Reporting', 'desc' => ''],
            '4' => ['name' => 'Incident Response Legal Preparation', 'desc' => ''],
            '5' => ['name' => 'Incident Response', 'desc' => ''],
        ],
        'area_1_threatcat_1_threat_15_question' => [
            '1' => ['name' => 'Data Quality & Integrity', 'desc' => ''],
            '2' => ['name' => 'Incident Reporting', 'desc' => ''],
            '3' => ['name' => 'Network/Infrastructure Services', 'desc' => ''],
            '4' => ['name' => 'Provider Internal Assessments', 'desc' => ''],
            '5' => ['name' => 'Third-Party Agreements', 'desc' => ''],
            '6' => ['name' => 'Supply Chain Governance Reviews', 'desc' => ''],
            '7' => ['name' => 'Supply Chain Metrics', 'desc' => ''],
            '8' => ['name' => 'Third-Party Assessments', 'desc' => ''],
            '9' => ['name' => 'Third-Party Audits', 'desc' => ''],
        ],
        'area_1_threatcat_1_threat_16_question' => [
            '1' => ['name' => 'Anti-Virus/Malicious Software', 'desc' => ''],
            '2' => ['name' => 'Vulnerability/Patch Management', 'desc' => ''],
            '3' => ['name' => 'Mobile Code', 'desc' => ''],
        ],
        'area_1_threatcat_1_threat_1_question_1_helper' => [
            '1' => ['name' => 'Vendor A - Governance - Application security - Statement 1 - Question 1'],
            '2' => ['name' => 'Vendor A - Governance - Application security - Statement 1 - Question 2'],
        ],
        'area_1_threatcat_1_threat_1_question_2_helper' => [
            '1' => ['name' => 'Vendor A - Governance - Application security - Statement 2 Question 1'],
        ],
    ];
    if ( $postId ) {
    	return update_post_meta( $postId, 'form_opts', $opts);
    }
    return false;
}
function facilityDefaultAssessment($postId=0)
{
    $opts = [
        'display_name' => 'Facility Risk',
        'desc' => 'Facility Risk Assessment',
        'icon' => '',
        'areas'=>[
            '1'=>['name' => 'Technical & Building Services', 'icon_menu' => '', 'icon_title' => '', 'desc' => 'Technical & Building Services', 'base' => '1'],
            '2'=>['name' => 'Sun Parlor Home', 'icon_menu' => '', 'icon_title' => '', 'desc' => 'Sun Parlor Home', 'base' => '1'],
        ],
        'area_1_threatcat'=>[
            '1'=>['name' => 'Mechanical Systems', 'desc' => 'Mechanical Systems'],
            '2'=>['name' => 'Electrical Systems', 'desc' => 'Electrical Systems'],
            '3'=>['name' => 'Access/Security/Life Safety', 'desc' => 'Access/Security/Life Safety'],
            '4'=>['name' => 'Asset Management', 'desc' => 'Asset Management'],
            '5'=>['name' => 'Accessibility', 'desc' => 'Accessibility'],
            '6'=>['name' => 'Emergency Preparedness', 'desc' => 'Emergency Preparedness'],
            '7'=>['name' => 'Hazardous Materials', 'desc' => 'Hazardous Materials'],
            '8'=>['name' => 'Communications', 'desc' => 'Communications'],
            '9'=>['name' => 'General Health & Safety', 'desc' => 'General Health & Safety'],
            '10'=>['name' => 'Insurance', 'desc' => 'Insurance'],
            '11'=>['name' => 'Fuel', 'desc' => 'Fuel'],
        ],
        'area_2_threatcat'=>[
            '1'=>['name' => 'Mechanical Systems', 'desc' => 'Mechanical Systems'],
            '2'=>['name' => 'Electrical Systems', 'desc' => 'Electrical Systems'],
            '3'=>['name' => 'Access/Security/Life Safety', 'desc' => 'Access/Security/Life Safety'],
            '4'=>['name' => 'Asset Management', 'desc' => 'Asset Management'],
            '5'=>['name' => 'Accessibility', 'desc' => 'Accessibility'],
            '6'=>['name' => 'Emergency Preparedness', 'desc' => 'Emergency Preparedness'],
            '7'=>['name' => 'Hazardous Materials', 'desc' => 'Hazardous Materials'],
            '8'=>['name' => 'Communications', 'desc' => 'Communications'],
            '9'=>['name' => 'General Health & Safety', 'desc' => 'General Health & Safety'],
            '10'=>['name' => 'Insurance', 'desc' => 'Insurance'],
            '11'=>['name' => 'Fuel', 'desc' => 'Fuel'],
        ],
        'area_1_threatcat_1_threat' => [
            '1'=>['name' => 'HVAC - heating, ventilation, and air-conditioning (including air filtration)'],
            '2'=>['name' => 'Plumbing - pipes and drainage infrastructure'],
            '3'=>['name' => 'Pumps/Compressors - operations and maintenance'],
            '4'=>['name' => 'Boilers - operations and maintenance'],
            '5'=>['name' => 'Elevators - operations and maintenance'],
            '6'=>['name' => 'Kitchens/Appliances - operations and maintenance'],
            '7'=>['name' => 'Backflow Preventer - operations and maintenance'],
            '8'=>['name' => 'Building Automation Systems    - operations and maintenance'],
            '9'=>['name' => 'Contractors - Service Level Agreements (SLA)'],
            '10'=>['name' => 'Preventative Maintenance - scheduled processes and procedures'],
            '11'=>['name' => 'Insurance Inspections/Compliance - adherence to requirements/standards'],
        ],
        'area_1_threatcat_2_threat' => [
            '1'=>['name' => 'Circuits/Load/Panels - adherence to requirements/standards'],
            '2'=>['name' => 'Indoor Lighting - emergency systems'],
            '3'=>['name' => 'Outdoor Lighting - safety and visibility'],
            '4'=>['name' => 'High Voltage/PPE - training and compliance'],
            '5'=>['name' => 'Water Infiltration - flood plain'],
            '6'=>['name' => 'Foundation Breaches - inspection'],
            '7'=>['name' => 'Washroom Capabilities - accessibility'],
            '8'=>['name' => 'Contractor Maintenance - scheduled processes and procedures'],
            '9'=>['name' => 'Warranty Compliance - system maintenance'],
        ],
        'area_1_threatcat_3_threat' => [
            '1'=>['name' => 'Generators - fuel reserves'],
            '2'=>['name' => 'Fire Alarms - maintenance'],
            '3'=>['name' => 'Fire Suppression - adherence to requirements/standards'],
            '4'=>['name' => 'Smoke Detectors - system maintenance'],
            '5'=>['name' => 'Evacuation Chairs - system maintenance'],
            '6'=>['name' => 'Building Automation System - operations and maintenance'],
            '7'=>['name' => 'Video Cameras - operations and maintenance'],
            '8'=>['name' => 'Threat Identification - processes and procedures'],
            '9'=>['name' => 'Evacuation Plans - processes and procedures'],
            '10'=>['name' => 'Signage - safety and visibility'],
            '11'=>['name' => 'Lighting - operations and maintenance'],
            '12'=>['name' => 'Contractor Maintenance - Service Level Agreements (SLA)'],
            '13'=>['name' => 'Physical Access - processes and procedures'],
            '14'=>['name' => 'Standards - processes and procedures'],
            '15'=>['name' => 'Training - processes and procedures'],
        ],
        'area_1_threatcat_4_threat' => [
            '1'=>['name' => 'Inventory - processes and procedures'],
            '2'=>['name' => 'Lifecycle - processes and procedures'],
            '3'=>['name' => 'Current Age - life expectancy'],
            '4'=>['name' => 'Condition Assessments - operations and maintenance'],
            '5'=>['name' => 'Level of Service - operations and maintenance'],
        ],
        'area_1_threatcat_5_threat' => [
            '1'=>['name' => 'Compliancy - standards and regulations'],
            '2'=>['name' => 'Washrooms - standards and regulations'],
            '3'=>['name' => 'Access Doors - compliance and regulations'],
            '4'=>['name' => 'Signage - compliance and regulations'],
        ],
        'area_1_threatcat_6_threat' => [
            '1'=>['name' => 'Facility Damage - processes and procedures'],
            '2'=>['name' => 'Impact - processes and procedures'],
            '3'=>['name' => 'Access - processes and procedures'],
            '4'=>['name' => 'First Aid - processes and procedures'],
        ],
        'area_1_threatcat_7_threat' => [
            '1'=>['name' => 'Workplace Hazardous Materials Information System & Globally Harmonized System of Classification and Labelling'],
            '2'=>['name' => 'Material Safety Data Sheets & Safety Data Sheets'],
        ],
        'area_1_threatcat_8_threat' => [
            '1'=>['name' => 'Systems - processes and procedures'],
            '2'=>['name' => 'Plans - processes and procedures'],
        ],
        'area_1_threatcat_9_threat' => [
            '1'=>['name' => 'Access - processes and procedures'],
            '2'=>['name' => 'Inspection - processes and procedures'],
        ],
        'area_1_threatcat_10_threat' => [
            '1'=>['name' => 'Policies - standards and regulations'],
        ],
        'area_1_threatcat_11_threat' => [
            '1'=>['name' => 'Storage - processes and procedures'],
            '2'=>['name' => 'Transportation - processes and procedures'],
            '3'=>['name' => 'Costs - processes and procedures'],
            '4'=>['name' => 'Supply - processes and procedures'],
            '5'=>['name' => 'Training - processes and procedures'],
        ],
        'area_2_threatcat_1_threat' => [
            '1'=>['name' => 'HVAC - heating, ventilation, and air-conditioning (including air filtration)'],
            '2'=>['name' => 'Plumbing - pipes and drainage infrastructure'],
            '3'=>['name' => 'Pumps/Compressors - operations and maintenance'],
            '4'=>['name' => 'Boilers - operations and maintenance'],
            '5'=>['name' => 'Elevators - operations and maintenance'],
            '6'=>['name' => 'Kitchens/Appliances - operations and maintenance'],
            '7'=>['name' => 'Backflow Preventer - operations and maintenance'],
            '8'=>['name' => 'Building Automation Systems    - operations and maintenance'],
            '9'=>['name' => 'Contractors - Service Level Agreements (SLA)'],
            '10'=>['name' => 'Preventative Maintenance - scheduled processes and procedures'],
            '11'=>['name' => 'Insurance Inspections/Compliance - adherence to requirements/standards'],
        ],
        'area_2_threatcat_2_threat' => [
            '1'=>['name' => 'Circuits/Load/Panels - adherence to requirements/standards'],
            '2'=>['name' => 'Indoor Lighting - emergency systems'],
            '3'=>['name' => 'Outdoor Lighting - safety and visibility'],
            '4'=>['name' => 'High Voltage/PPE - training and compliance'],
            '5'=>['name' => 'Water Infiltration - flood plain'],
            '6'=>['name' => 'Foundation Breaches - inspection'],
            '7'=>['name' => 'Washroom Capabilities - accessibility'],
            '8'=>['name' => 'Contractor Maintenance - scheduled processes and procedures'],
            '9'=>['name' => 'Warranty Compliance - system maintenance'],
        ],
        'area_2_threatcat_3_threat' => [
            '1'=>['name' => 'Generators - fuel reserves'],
            '2'=>['name' => 'Fire Alarms - maintenance'],
            '3'=>['name' => 'Fire Suppression - adherence to requirements/standards'],
            '4'=>['name' => 'Smoke Detectors - system maintenance'],
            '5'=>['name' => 'Evacuation Chairs - system maintenance'],
            '6'=>['name' => 'Building Automation System - operations and maintenance'],
            '7'=>['name' => 'Video Cameras - operations and maintenance'],
            '8'=>['name' => 'Threat Identification - processes and procedures'],
            '9'=>['name' => 'Evacuation Plans - processes and procedures'],
            '10'=>['name' => 'Signage - safety and visibility'],
            '11'=>['name' => 'Lighting - operations and maintenance'],
            '12'=>['name' => 'Contractor Maintenance - Service Level Agreements (SLA)'],
            '13'=>['name' => 'Physical Access - processes and procedures'],
            '14'=>['name' => 'Standards - processes and procedures'],
            '15'=>['name' => 'Training - processes and procedures'],
        ],
        'area_2_threatcat_4_threat' => [
            '1'=>['name' => 'Inventory - processes and procedures'],
            '2'=>['name' => 'Lifecycle - processes and procedures'],
            '3'=>['name' => 'Current Age - life expectancy'],
            '4'=>['name' => 'Condition Assessments - operations and maintenance'],
            '5'=>['name' => 'Level of Service - operations and maintenance'],
        ],
        'area_2_threatcat_5_threat' => [
            '1'=>['name' => 'Compliancy - standards and regulations'],
            '2'=>['name' => 'Washrooms - standards and regulations'],
            '3'=>['name' => 'Access Doors - compliance and regulations'],
            '4'=>['name' => 'Signage - compliance and regulations'],
        ],
        'area_2_threatcat_6_threat' => [
            '1'=>['name' => 'Facility Damage - processes and procedures'],
            '2'=>['name' => 'Impact - processes and procedures'],
            '3'=>['name' => 'Access - processes and procedures'],
            '4'=>['name' => 'First Aid - processes and procedures'],
        ],
        'area_2_threatcat_7_threat' => [
            '1'=>['name' => 'Workplace Hazardous Materials Information System & Globally Harmonized System of Classification and Labelling'],
            '2'=>['name' => 'Material Safety Data Sheets & Safety Data Sheets'],
        ],
        'area_2_threatcat_8_threat' => [
            '1'=>['name' => 'Systems - processes and procedures'],
            '2'=>['name' => 'Plans - processes and procedures'],
        ],
        'area_2_threatcat_9_threat' => [
            '1'=>['name' => 'Access - processes and procedures'],
            '2'=>['name' => 'Inspection - processes and procedures'],
        ],
        'area_2_threatcat_10_threat' => [
            '1'=>['name' => 'Policies - standards and regulations'],
        ],
        'area_2_threatcat_11_threat' => [
            '1'=>['name' => 'Storage - processes and procedures'],
            '2'=>['name' => 'Transportation - processes and procedures'],
            '3'=>['name' => 'Costs - processes and procedures'],
            '4'=>['name' => 'Supply - processes and procedures'],
            '5'=>['name' => 'Training - processes and procedures'],
        ],

        'area_1_threatcat_1_threat_1_question'=>[
            '1'=>['name' => 'Is your HVAC more than 5 years old?'],
            '2'=>['name' => 'Are HVAC filtration systems replaced regularly?'],
            '3'=>['name' => 'Do you have redundant HVAC systems for critical areas such as server rooms?'],
        ],
        'area_1_threatcat_1_threat_2_question'=>[
            '1'=>['name' => 'Are all pipes winter-proofed?'],
            '2'=>['name' => 'Is plumbing and drainage infrastructure inspected regularly to ensure that it is in proper working order (including irrigation systems, sprinklers, taps, drainpipes and gutters)?'],
        ],
        'area_1_threatcat_1_threat_3_question'=>[
            '1'=>['name' => 'Are any pumps or compressors more than 5 years old?'],
        ],
        'area_1_threatcat_1_threat_4_question'=>[
            '1'=>['name' => 'Are any boilers more than 5 years old?'],
            '2'=>['name' => 'Do you have redundant pumps and motors for boilers?'],
            '3'=>['name' => 'Do you have any pop off safety valves over 5 years old?'],
        ],
        'area_1_threatcat_1_threat_5_question'=>[
            '1'=>['name' => 'Are elevators maintained regularly?'],
            '2'=>['name' => 'Do all elevators have annual TSSA certification?'],
        ],
        'area_1_threatcat_1_threat_6_question'=>[
            '1'=>['name' => 'Do you rely on facility kitchen appliances to provide meals for vulnerable people?'],
        ],
        'area_1_threatcat_1_threat_7_question'=>[
            '1'=>['name' => 'Do you perform an annual inspection and obtain certification?'],
            ],
        'area_1_threatcat_1_threat_8_question'=>[
            '1'=>['name' => 'Are all points properly identified and operating as required?'],
        ],
        'area_1_threatcat_1_threat_9_question'=>[
            '1'=>['name' => 'Do you have Service Level Agreements in place with all contractors?'],
        ],
        'area_1_threatcat_1_threat_10_question'=>[
            '1'=>['name' => 'Are all mechanical systems maintained regularly?'],
        ],
        'area_1_threatcat_1_threat_11_question'=>[
            '1'=>['name' => 'Are you compliant with insurance requirements?'],
            '2'=>['name' => 'Are generators maintained to insurance standards?'],
        ],

        'area_1_threatcat_2_threat_1_question'=>[
            '1'=>['name' => 'Are all circuits and panels CSA approved?'],
        ],
        'area_1_threatcat_2_threat_2_question'=>[
            '1'=>['name' => 'Do you have an emergency lighting system?'],
        ],
        'area_1_threatcat_2_threat_3_question'=>[
            '1'=>['name' => 'Is all outdoor lighting adequate for safety and visibility purposes?'],
        ],
        'area_1_threatcat_2_threat_4_question'=>[
            '1'=>['name' => 'Are staff trained in dealing with high voltage systems?'],
            '2'=>['name' => 'Is electrical equipment and infrastructure inspected and tested regularly by qualified personnel (ESA) to ensure that it is in proper, safe working order (including switchboards, power points, control gear and leads)?'],
            '3'=>['name' => 'Do you have enough PPE in stock for both High Voltage and Regular work?'],
            '4'=>['name' => 'Is your PPE appropriate and adequate?'],
        ],
        'area_1_threatcat_2_threat_5_question'=>[
            '1'=>['name' => 'Are facilities on a 25-year flood plain?'],
        ],
        'area_1_threatcat_2_threat_6_question'=>[
            '1'=>['name' => 'Do you inspect building foundations regularly?'],
        ],
        'area_1_threatcat_2_threat_7_question'=>[
            '1'=>['name' => 'Are washrooms accessible in new facilities?'],
        ],
        'area_1_threatcat_2_threat_8_question'=>[
            '1'=>['name' => 'Do contractors perform regular maintenance  on equipment they are contracted to look after?'],
        ],
        'area_1_threatcat_2_threat_9_question'=>[
            '1'=>['name' => 'Are all components and systems maintained appropriately to ensure warranty compliance?'],
        ],

        'area_1_threatcat_3_threat_1_question'=>[
            '1'=>['name' => 'Do you have fuel reserves for generators? For example, onsite or an agreement with suppliers.'],
        ],
        'area_1_threatcat_3_threat_2_question'=>[
            '1'=>['name' => 'Are fire alarms tested at least monthly?'],
        ],
        'area_1_threatcat_3_threat_3_question'=>[
            '1'=>['name' => 'Are fire suppression systems in areas such as server rooms (or other areas where there is expensive equipment) of the type that could cause water damage?'],
            '2'=>['name' => 'Are fire suppression systems automated for key areas?'],
        ],
        'area_1_threatcat_3_threat_4_question'=>[
            '1'=>['name' => 'Are smoke detectors tested at least twice a year?'],
        ],
        'area_1_threatcat_3_threat_5_question'=>[
            '1'=>['name' => 'Are evacuation chairs inspected annually?'],
        ],
        'area_1_threatcat_3_threat_6_question'=>[
            '1'=>['name' => 'Do building automation systems have safety interlocks incorporated?'],
            '2'=>['name' => 'Are interlocks and sensors inspected and tested regularly?'],
            '3'=>['name' => 'Do automated systems have safety features such as automatic shut off of air vents to help suppress fires?'],
        ],
        'area_1_threatcat_3_threat_7_question'=>[
            '1'=>['name' => 'Do all video cameras have battery backup or are connected to a generator?'],
            '2'=>['name' => '      42  If battery backup is used, are batteries tested and replaced regularly?'],
            '3'=>['name' => 'Have default passwords been changed on cameras?'],
            '4'=>['name' => 'Are cameras monitored 24 x 7?'],
            '5'=>['name' => 'Is video surveillance recorded and reviewed regularly?'],
            '6'=>['name' => 'Is recorded video footage kept for an appropriate length of time before being overwritten?'],
        ],
        'area_1_threatcat_3_threat_8_question'=>[
            '1'=>['name' => 'Do you have a threat identification program?'],
        ],
        'area_1_threatcat_3_threat_9_question'=>[
            '1'=>['name' => 'Are your evacuation plans up  to date and tested at least annually?'],
            '2'=>['name' => 'Does your facility have emergency exit and evacuation points, are these points signed?'],
            '3'=>['name' => '      50  Are your staff trained and/or made aware of emergency evacuation procedures?'],
            '4'=>['name' => 'Are your visitors made aware of emergency evacuation procedures?'],
        ],
        'area_1_threatcat_3_threat_10_question'=>[
            '1'=>['name' => 'Do all areas including exits have appropriate and visible signage?'],
        ],
        'area_1_threatcat_3_threat_11_question'=>[
            '1'=>['name' => 'Do you have emergency lighting in the event of a power failure?'],
            '2'=>['name' => 'Is emergency lighting on battery backup or connected to a generator?'],
            '3'=>['name' => 'Is there sufficient lighting in and around your facility to ensure the safe conduct of activities and safe access (including playing areas, parking lots and security lighting)?'],
        ],
        'area_1_threatcat_3_threat_12_question'=>[
            '1'=>['name' => 'Do contractors perform regular maintenance  on equipment they are contracted to look after?'],
        ],
        'area_1_threatcat_3_threat_13_question'=>[
            '1'=>['name' => 'Are all facilities secured through physical or electronic locks?'],
            '2'=>['name' => 'Are all facilities secured through physical or electronic locks?'],
            '3'=>['name' => 'Are vehicles and personnel entering the facility inspected and/or screened for security purposes?'],
            '4'=>['name' => 'Are power tools and other dangerous equipment locked away securely?'],
            '5'=>['name' => 'Is access restricted by locked doors etc. so that only authorized personnel can enter certain areas?'],
            '6'=>['name' => 'Are all visitors escorted while in the facility?'],
        ],
        'area_1_threatcat_3_threat_14_question'=>[
            '1'=>['name' => 'Do your facilities comply with relevant standards (including training and competition areas, run-off areas and disability access)?'],
            '2'=>['name' => 'Is your physical building infrastructure of a suitable standard with regards to health and hygiene (including air conditioning, ventilation)?'],
        ],
        'area_1_threatcat_3_threat_15_question'=>[
            '1'=>['name' => 'Are all Facility personnel adequately trained on the use and operation of equipment?'],
        ],
        'area_1_threatcat_4_threat_1_question'=>[
            '1'=>['name' => 'Do you maintain an up to date asset inventory?'],
            '2'=>['name' => 'Is your inventory system automated?'],
        ],
        'area_1_threatcat_4_threat_2_question'=>[
            '1'=>['name' => 'Do you have an asset replacement schedule based on expected life of asset?'],
            '2'=>['name' => 'Do you have a facility development plan addressing your long, medium and short-term facility needs and facility management and maintenance issues?'],
        ],
        'area_1_threatcat_4_threat_3_question'=>[
            '1'=>['name' => 'Do you have any assets currently past the recommended life expectancy?'],
        ],
        'area_1_threatcat_4_threat_4_question'=>[
            '1'=>['name' => 'Do you receive recommendations for replacement of assets after preventative maintenance?'],
            '2'=>['name' => 'Does your organization make regular inspections of all fixed and non-fixed equipment to ensure that it is in proper working order (including HVAC, generator, elevator, roof, building, etc. )?'],
            '3'=>['name' => 'Are appropriate condition assessment processes and standards used for each different type of equipment?'],
        ],
        'area_1_threatcat_4_threat_5_question'=>[
            '1'=>['name' => 'Are Levels of Service adequate for all functions?'],
        ],
        'area_1_threatcat_5_threat_1_question'=>[
            '1'=>['name' => 'Do all facilities meet accessibility compliance standards?'],
        ],
        'area_1_threatcat_5_threat_2_question'=>[
            '1'=>['name' => 'Do all washrooms in new facilities meet accessibility compliance standards?'],
            '2'=>['name' => 'If required, do all facilities have a universal washroom?'],
        ],
        'area_1_threatcat_5_threat_3_question'=>[
            '1'=>['name' => 'Where required, do access doors meet accessibility compliance standards?'],
        ],
        'area_1_threatcat_5_threat_4_question'=>[
            '1'=>['name' => 'Do elevators and other items with signage have alternative communications methods such as braille?'],
        ],
        'area_1_threatcat_6_threat_1_question'=>[
            '1'=>['name' => 'Do you have an Emergency Response Plan?'],
            '2'=>['name' => 'Is your Emergency Response Plan tested annually?'],
        ],
        'area_1_threatcat_6_threat_2_question'=>[
            '1'=>['name' => 'Has an Impact Assessment been performed for effect on business in the event of a disaster?'],
            '2'=>['name' => 'Has an Impact Assessment been performed for effect on the public in the event of a disaster?'],
        ],
        'area_1_threatcat_6_threat_3_question'=>[
            '1'=>['name' => 'Is unobstructed emergency vehicle access available to all areas?'],
        ],
        'area_1_threatcat_6_threat_4_question'=>[
            '1'=>['name' => 'Do you have a designated first aid room with easy access and clear signage (including ambulance access)?'],
            '2'=>['name' => 'Is your first aid room of a suitable standard with regards to cleanliness, hygiene and sterility?'],
            '3'=>['name' => 'Are first aid supplies and equipment checked regularly and stored appropriately?'],
        ],
        'area_1_threatcat_7_threat_1_question'=>[
            '1'=>['name' => 'Are all hazardous materials identified?'],
            '2'=>['name' => 'Are all hazardous materials locked away safely?'],
            '3'=>['name' => 'Are all appropriate staff trained on WHMIS/GHS?'],
        ],
        'area_1_threatcat_7_threat_2_question'=>[
            '1'=>['name' => 'Are MSDS/SDS sheets available for all hazardous materials?'],
            '2'=>['name' => 'Are MSDS/SDS sheets updated regularly?'],
            '3'=>['name' => 'Are MSDS/SDS sheets available in all appropriate languages?'],
        ],
        'area_1_threatcat_8_threat_1_question'=>[
            '1'=>['name' => 'Do emergency communications systems such as Dispatch have redundancy?'],
            '2'=>['name' => 'Do you have Service Level Agreements with third parties who provide emergency communication services?'],
        ],
        'area_1_threatcat_8_threat_2_question'=>[
            '1'=>['name' => 'Do you have a communication plan in place for incidents?'],
            '2'=>['name' => 'Do you have a documented escalation procedure for incidents?'],
            '3'=>['name' => 'Do you maintain a list of key personnel and other contacts to be used for incidents?'],
        ],
        'area_1_threatcat_9_threat_1_question'=>[
            '1'=>['name' => 'Are your amenities and change room facilities cleaned and checked regularly?'],
            '2'=>['name' => 'Are your parking lots, driveways and footpaths safe and adequate?'],
        ],
        'area_1_threatcat_9_threat_2_question'=>[
            '1'=>['name' => 'Are your facilities inspected regularly for uneven surfaces, damage, potholes, correct markings, and other dangerous items and obstructions?'],
        ],
        'area_1_threatcat_10_threat_1_question'=>[
            '1'=>['name' => 'Do you have insurance to cover building, contents, liability, personal accident and injury, public liability, volunteer workers, etc.?'],
            '2'=>['name' => 'Are your insurance policies reviewed annually?'],
        ],
        'area_1_threatcat_11_threat_1_question'=>[
            '1'=>['name' => 'Is fuel stored in a place where hazardous vapors could affect personnel?'],
            '2'=>['name' => 'Do areas for fuel storage have appropriate signage?'],
            '3'=>['name' => 'Are tools and other items that could cause sparks prohibited from fuel storage areas?'],
            '4'=>['name' => 'Do fuel storage areas meet recognized standards?'],
            '5'=>['name' => 'Do fuel storage areas have appropriate fire suppression systems?'],
        ],
        'area_1_threatcat_11_threat_2_question'=>[
            '1'=>['name' => 'Is fuel transported using safe vehicles?'],
            '2'=>['name' => 'Are all areas cleared of non-essential personnel before fuel is transferred from delivery vehicles to storage tanks?'],
            '3'=>['name' => 'Do you have safety procedures for drivers when filling up vehicles with fuel?'],
        ],
        'area_1_threatcat_11_threat_3_question'=>[
            '1'=>['name' => 'Are fuel costs (prices) locked in for a significant period of time?'],
            '2'=>['name' => 'Do budgets take sudden fuel price hikes into consideration?'],
        ],
        'area_1_threatcat_11_threat_4_question'=>[
            '1'=>['name' => 'Are there enough fuel reserves on site or in the supply line?'],
        ],
        'area_1_threatcat_11_threat_5_question'=>[
            '1'=>['name' => 'Are all personnel who handle fuel trained on safety procedures?'],
        ],
        'area_2_threatcat_1_threat_1_question'=>[
            '1'=>['name' => 'Is your HVAC more than 5 years old?'],
            '2'=>['name' => 'Are HVAC filtration systems replaced regularly?'],
            '3'=>['name' => 'Do you have redundant HVAC systems for critical areas such as server rooms?'],
        ],
        'area_2_threatcat_1_threat_2_question'=>[
            '1'=>['name' => 'Are all pipes winter-proofed?'],
            '2'=>['name' => 'Is plumbing and drainage infrastructure inspected regularly to ensure that it is in proper working order (including irrigation systems, sprinklers, taps, drainpipes and gutters)?'],
        ],
        'area_2_threatcat_1_threat_3_question'=>[
            '1'=>['name' => 'Are any pumps or compressors more than 5 years old?'],
        ],
        'area_2_threatcat_1_threat_4_question'=>[
            '1'=>['name' => 'Are any boilers more than 5 years old?'],
            '2'=>['name' => 'Do you have redundant pumps and motors for boilers?'],
            '3'=>['name' => 'Do you have any pop off safety valves over 5 years old?'],
        ],
        'area_2_threatcat_1_threat_5_question'=>[
            '1'=>['name' => 'Are elevators maintained regularly?'],
            '2'=>['name' => 'Do all elevators have annual TSSA certification?'],
        ],
        'area_2_threatcat_1_threat_6_question'=>[
            '1'=>['name' => 'Do you rely on facility kitchen appliances to provide meals for vulnerable people?'],
        ],
        'area_2_threatcat_1_threat_7_question'=>[
            '1'=>['name' => 'Do you perform an annual inspection and obtain certification?'],
            ],
        'area_2_threatcat_1_threat_8_question'=>[
            '1'=>['name' => 'Are all points properly identified and operating as required?'],
        ],
        'area_2_threatcat_1_threat_9_question'=>[
            '1'=>['name' => 'Do you have Service Level Agreements in place with all contractors?'],
        ],
        'area_2_threatcat_1_threat_10_question'=>[
            '1'=>['name' => 'Are all mechanical systems maintained regularly?'],
        ],
        'area_2_threatcat_1_threat_11_question'=>[
            '1'=>['name' => 'Are you compliant with insurance requirements?'],
            '2'=>['name' => 'Are generators maintained to insurance standards?'],
        ],
        'area_2_threatcat_2_threat_1_question'=>[
            '1'=>['name' => 'Are all circuits and panels CSA approved?'],
        ],
        'area_2_threatcat_2_threat_2_question'=>[
            '1'=>['name' => 'Do you have an emergency lighting system?'],
        ],
        'area_2_threatcat_2_threat_3_question'=>[
            '1'=>['name' => 'Is all outdoor lighting adequate for safety and visibility purposes?'],
        ],
        'area_2_threatcat_2_threat_4_question'=>[
            '1'=>['name' => 'Are staff trained in dealing with high voltage systems?'],
            '2'=>['name' => 'Is electrical equipment and infrastructure inspected and tested regularly by qualified personnel (ESA) to ensure that it is in proper, safe working order (including switchboards, power points, control gear and leads)?'],
            '3'=>['name' => 'Do you have enough PPE in stock for both High Voltage and Regular work?'],
            '4'=>['name' => 'Is your PPE appropriate and adequate?'],
        ],
        'area_2_threatcat_2_threat_5_question'=>[
            '1'=>['name' => 'Are facilities on a 25-year flood plain?'],
        ],
        'area_2_threatcat_2_threat_6_question'=>[
            '1'=>['name' => 'Do you inspect building foundations regularly?'],
        ],
        'area_2_threatcat_2_threat_7_question'=>[
            '1'=>['name' => 'Are washrooms accessible in new facilities?'],
        ],
        'area_2_threatcat_2_threat_8_question'=>[
            '1'=>['name' => 'Do contractors perform regular maintenance  on equipment they are contracted to look after?'],
        ],
        'area_2_threatcat_2_threat_9_question'=>[
            '1'=>['name' => 'Are all components and systems maintained appropriately to ensure warranty compliance?'],
        ],
        'area_2_threatcat_3_threat_1_question'=>[
            '1'=>['name' => 'Do you have fuel reserves for generators? For example, onsite or an agreement with suppliers.'],
        ],
        'area_2_threatcat_3_threat_2_question'=>[
            '1'=>['name' => 'Are fire alarms tested at least monthly?  '],
        ],
        'area_2_threatcat_3_threat_3_question'=>[
            '1'=>['name' => 'Are fire suppression systems in areas such as server rooms (or other areas where there is expensive equipment) of the type that could cause water damage?'],
            '2'=>['name' => 'Are fire suppression systems automated for key areas?'],
        ],
        'area_2_threatcat_3_threat_4_question'=>[
            '1'=>['name' => 'Are smoke detectors tested at least twice a year?'],
        ],
        'area_2_threatcat_3_threat_5_question'=>[
            '1'=>['name' => 'Are evacuation chairs inspected annually?'],
        ],
        'area_2_threatcat_3_threat_6_question'=>[
            '1'=>['name' => 'Do building automation systems have safety interlocks incorporated?'],
            '2'=>['name' => 'Are interlocks and sensors inspected and tested regularly?'],
            '3'=>['name' => 'Do automated systems have safety features such as automatic shut off of air vents to help suppress fires?'],
        ],
        'area_2_threatcat_3_threat_7_question'=>[
            '1'=>['name' => 'Do all video cameras have battery backup or are connected to a generator?'],
            '2'=>['name' => 'If battery backup is used, are batteries tested and replaced regularly?'],
            '3'=>['name' => 'Have default passwords been changed on cameras?'],
            '4'=>['name' => 'Are cameras monitored 24 x 7?'],
            '5'=>['name' => 'Is video surveillance recorded and reviewed regularly?'],
            '6'=>['name' => 'Is recorded video footage kept for an appropriate length of time before being overwritten?'],
        ],
        'area_2_threatcat_3_threat_8_question'=>[
            '1'=>['name' => 'Do you have a threat identification program?'],
        ],
        'area_2_threatcat_3_threat_9_question'=>[
            '1'=>['name' => 'Are your evacuation plans up  to date and tested at least annually?'],
            '2'=>['name' => 'Does your facility have emergency exit and evacuation points, are these points signed?'],
            '3'=>['name' => 'Are your staff trained and/or made aware of emergency evacuation procedures?'],
            '4'=>['name' => 'Are your visitors made aware of emergency evacuation procedures?'],
        ],
        'area_2_threatcat_3_threat_10_question'=>[
            '1'=>['name' => 'Do all areas including exits have appropriate and visible signage?'],
        ],
        'area_2_threatcat_3_threat_11_question'=>[
            '1'=>['name' => 'Do you have emergency lighting in the event of a power failure?'],
            '2'=>['name' => 'Is emergency lighting on battery backup or connected to a generator?'],
            '3'=>['name' => 'Is there sufficient lighting in and around your facility to ensure the safe conduct of activities and safe access (including playing areas, parking lots and security lighting)?'],
        ],
        'area_2_threatcat_3_threat_12_question'=>[
            '1'=>['name' => 'Do contractors perform regular maintenance on equipment they are contracted to look after?'],
        ],
        'area_2_threatcat_3_threat_13_question'=>[
            '1'=>['name' => 'Are all facilities secured through physical or electronic locks?'],
            '2'=>['name' => 'Do you have door alarms or other mechanisms to alert you if a secure area has been breached?'],
            '3'=>['name' => 'Are vehicles and personnel entering the facility inspected and/or screened for security purposes?'],
            '4'=>['name' => 'Are power tools and other dangerous equipment locked away securely?'],
            '5'=>['name' => 'Is access restricted by locked doors etc. so that only authorized personnel can enter certain areas?'],
            '6'=>['name' => 'Are all visitors escorted while in the facility?'],
        ],
        'area_2_threatcat_3_threat_14_question'=>[
            '1'=>['name' => 'Do your facilities comply with relevant standards (including training and competition areas, run-off areas and disability access)?'],
            '2'=>['name' => 'Is your physical building infrastructure of a suitable standard with regards to health and hygiene (including air conditioning, ventilation)?'],
        ],
        'area_2_threatcat_3_threat_15_question'=>[
            '1'=>['name' => 'Are all Facility personnel adequately trained on the use and operation of equipment?'],
        ],
        'area_2_threatcat_4_threat_1_question'=>[
            '1'=>['name' => 'Do you maintain an up to date asset inventory?'],
            '2'=>['name' => 'Is your inventory system automated?'],
        ],
        'area_2_threatcat_4_threat_2_question'=>[
            '1'=>['name' => 'Do you have an asset replacement schedule based on expected life of asset?'],
            '2'=>['name' => 'Do you have a facility development plan addressing your long, medium and short-term facility needs and facility management and maintenance issues?'],
        ],
        'area_2_threatcat_4_threat_3_question'=>[
            '1'=>['name' => 'Do you have any assets currently past the recommended life expectancy?'],
        ],
        'area_2_threatcat_4_threat_4_question'=>[
            '1'=>['name' => 'Do you receive recommendations for replacement of assets after preventative maintenance?'],
            '2'=>['name' => 'Does your organization make regular inspections of all fixed and non-fixed equipment to ensure that it is in proper working order (including HVAC, generator, elevator, roof, building, etc. )?'],
            '3'=>['name' => 'Are appropriate condition assessment processes and standards used for each different type of equipment?'],
        ],
        'area_2_threatcat_4_threat_5_question'=>[
            '1'=>['name' => 'Are Levels of Service adequate for all functions?'],
        ],

        'area_2_threatcat_5_threat_1_question'=>[
            '1'=>['name' => 'Do all facilities meet accessibility compliance standards?'],
        ],
        'area_2_threatcat_5_threat_2_question'=>[
            '1'=>['name' => 'Do all washrooms in new facilities meet accessibility compliance standards'],
            '2'=>['name' => 'If required, do all facilities have a universal washroom?'],
        ],
        'area_2_threatcat_5_threat_3_question'=>[
            '1'=>['name' => 'Where required, do access doors meet accessibility compliance standards?'],
        ],
        'area_2_threatcat_5_threat_4_question'=>[
            '1'=>['name' => 'Do elevators and other items with signage have alternative communications methods such as braille?'],
        ],
        'area_2_threatcat_6_threat_1_question'=>[
            '1'=>['name' => 'Do you have an Emergency Response Plan?'],
            '2'=>['name' => 'Is your Emergency Response Plan tested annually?'],
        ],
        'area_2_threatcat_6_threat_2_question'=>[
            '1'=>['name' => 'Has an Impact Assessment been performed for effect on business in the event of a disaster?'],
            '2'=>['name' => 'Has an Impact Assessment been performed for effect on the public in the event of a disaster?'],
        ],
        'area_2_threatcat_6_threat_3_question'=>[
            '1'=>['name' => 'Is unobstructed emergency vehicle access available to all areas?'],
        ],
        'area_2_threatcat_6_threat_4_question'=>[
            '1'=>['name' => 'Do you have a designated first aid room with easy access and clear signage (including ambulance access)?'],
            '2'=>['name' => 'Is your first aid room of a suitable standard with regards to cleanliness, hygiene and sterility?'],
            '3'=>['name' => 'Are first aid supplies and equipment checked regularly and stored appropriately?'],
        ],
        'area_2_threatcat_7_threat_1_question'=>[
            '1'=>['name' => 'Are all hazardous materials identified?'],
            '2'=>['name' => 'Are all hazardous materials locked away safely?'],
            '3'=>['name' => 'Are all appropriate staff trained on WHMIS/GHS?'],
        ],
        'area_2_threatcat_7_threat_2_question'=>[
            '1'=>['name' => 'Are MSDS/SDS sheets available for all hazardous materials?'],
            '2'=>['name' => 'Are MSDS/SDS sheets updated regularly?'],
            '3'=>['name' => 'Are MSDS/SDS sheets available in all appropriate languages?'],
        ],
        'area_2_threatcat_8_threat_1_question'=>[
            '1'=>['name' => 'Do emergency communications systems such as Dispatch have redundancy?'],
            '2'=>['name' => 'Do you have Service Level Agreements with third parties who provide emergency communication services?'],
        ],
        'area_2_threatcat_8_threat_2_question'=>[
            '1'=>['name' => 'Do you have a communication plan in place for incidents?'],
            '2'=>['name' => 'Do you have a documented escalation procedure for incidents?'],
            '3'=>['name' => 'Do you maintain a list of key personnel and other contacts to be used for incidents?'],
        ],
        'area_2_threatcat_9_threat_1_question'=>[
            '1'=>['name' => 'Are your amenities and change room facilities cleaned and checked regularly?'],
            '2'=>['name' => 'Are your parking lots, driveways and footpaths safe and adequate?'],
        ],
        'area_2_threatcat_9_threat_2_question'=>[
            '1'=>['name' => 'Are your facilities inspected regularly for uneven surfaces, damage, potholes, correct markings, and other dangerous items and obstructions?'],
        ],
        'area_2_threatcat_10_threat_1_question'=>[
            '1'=>['name' => 'Do you have insurance to cover building, contents, liability, personal accident and injury, public liability, volunteer workers, etc. ?'],
            '2'=>['name' => 'Are your insurance policies reviewed annually?'],
        ],
        'area_2_threatcat_11_threat_1_question'=>[
            '1'=>['name' => 'Is fuel stored in a place where hazardous vapors could affect personnel?'],
            '2'=>['name' => 'Do areas for fuel storage have appropriate signage?'],
            '3'=>['name' => 'Are tools and other items that could cause sparks prohibited from fuel storage areas?'],
            '4'=>['name' => 'Do fuel storage areas meet recognized standards?'],
            '5'=>['name' => 'Do fuel storage areas have appropriate fire suppression systems?'],
        ],
        'area_2_threatcat_11_threat_2_question'=>[
            '1'=>['name' => 'Is fuel transported using safe vehicles?'],
            '2'=>['name' => 'Are all areas cleared of non-essential personnel before fuel is transferred from delivery vehicles to storage tanks?'],
            '3'=>['name' => 'Do you have safety procedures for drivers when filling up vehicles with fuel?'],
        ],
        'area_2_threatcat_11_threat_3_question'=>[
            '1'=>['name' => 'Are fuel costs (prices) locked in for a significant period of time?'],
            '2'=>['name' => 'Do budgets take sudden fuel price hikes into consideration?'],
        ],
        'area_2_threatcat_11_threat_4_question'=>[
            '1'=>['name' => 'Are there enough fuel reserves on site or in the supply line?'],
        ],
        'area_2_threatcat_11_threat_5_question'=>[
            '1'=>['name' => 'Are all personnel who handle fuel trained on safety procedures?'],
        ], 
    ];
    if ( $postId ) {
        return update_post_meta( $postId, 'form_opts', $opts);
    }
    return false;
}
?>