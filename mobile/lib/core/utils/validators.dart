/// Validation Utilities
/// 
/// Hii file ina validation functions zinazotumika kwa form inputs.
/// Inajumuisha:
/// - Email validation
/// - Phone validation
/// - Password validation
/// - Name validation
/// - Required field validation

class Validators {
  // ──────────────────────────────────────────────────────────
  // EMAIL VALIDATION
  // ──────────────────────────────────────────────────────────
  static String? validateEmail(String? value) {
    if (value == null || value.isEmpty) {
      return 'Barua pepe inahitajika';
    }
    
    // Simple email regex
    final emailRegex = RegExp(r'^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$');
    if (!emailRegex.hasMatch(value)) {
      return 'Barua pepe si sahihi';
    }
    
    return null;
  }
  
  // ──────────────────────────────────────────────────────────
  // PHONE VALIDATION
  // ──────────────────────────────────────────────────────────
  static String? validatePhone(String? value) {
    if (value == null || value.isEmpty) {
      return 'Namba ya simu inahitajika';
    }
    
    // Remove spaces and dashes
    final cleanPhone = value.replaceAll(RegExp(r'[\s-]'), '');
    
    // Check if it's a valid phone number (10-15 digits)
    final phoneRegex = RegExp(r'^[0-9]{10,15}$');
    if (!phoneRegex.hasMatch(cleanPhone)) {
      return 'Namba ya simu si sahihi';
    }
    
    return null;
  }
  
  // ──────────────────────────────────────────────────────────
  // PASSWORD VALIDATION
  // ──────────────────────────────────────────────────────────
  static String? validatePassword(String? value) {
    if (value == null || value.isEmpty) {
      return 'Nenosiri linahitajika';
    }
    
    if (value.length < 6) {
      return 'Nenosiri lazima liwe na angalau herufi 6';
    }
    
    return null;
  }
  
  // ──────────────────────────────────────────────────────────
  // CONFIRM PASSWORD VALIDATION
  // ──────────────────────────────────────────────────────────
  static String? validateConfirmPassword(String? value, String? password) {
    if (value == null || value.isEmpty) {
      return 'Thibitisha nenosiri';
    }
    
    if (value != password) {
      return 'Nenosiri hazilingani';
    }
    
    return null;
  }
  
  // ──────────────────────────────────────────────────────────
  // NAME VALIDATION
  // ──────────────────────────────────────────────────────────
  static String? validateName(String? value) {
    if (value == null || value.isEmpty) {
      return 'Jina linahitajika';
    }
    
    if (value.length < 2) {
      return 'Jina lazima liwe na angalau herufi 2';
    }
    
    return null;
  }
  
  // ──────────────────────────────────────────────────────────
  // REQUIRED FIELD VALIDATION
  // ──────────────────────────────────────────────────────────
  static String? validateRequired(String? value, {String? fieldName}) {
    if (value == null || value.isEmpty) {
      return fieldName != null ? '$fieldName inahitajika' : 'Uwanja huu unahitajika';
    }
    
    return null;
  }
  
  // ──────────────────────────────────────────────────────────
  // MIN LENGTH VALIDATION
  // ──────────────────────────────────────────────────────────
  static String? validateMinLength(String? value, int minLength, {String? fieldName}) {
    if (value == null || value.isEmpty) {
      return fieldName != null ? '$fieldName inahitajika' : 'Uwanja huu unahitajika';
    }
    
    if (value.length < minLength) {
      return fieldName != null 
          ? '$fieldName lazima liwe na angalau herufi $minLength'
          : 'Lazima liwe na angalau herufi $minLength';
    }
    
    return null;
  }
  
  // ──────────────────────────────────────────────────────────
  // MAX LENGTH VALIDATION
  // ──────────────────────────────────────────────────────────
  static String? validateMaxLength(String? value, int maxLength, {String? fieldName}) {
    if (value != null && value.length > maxLength) {
      return fieldName != null 
          ? '$fieldName haliwezi kuwa zaidi ya herufi $maxLength'
          : 'Haliwezi kuwa zaidi ya herufi $maxLength';
    }
    
    return null;
  }
}
