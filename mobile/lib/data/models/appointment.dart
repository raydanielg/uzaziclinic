/// Appointment Model
/// 
/// Model ya appointment inayowakilisha miadi ya mgonjwa.
/// Inajumuisha:
/// - Appointment details (date, time, status)
/// - Patient info
/// - Doctor info
/// - Symptoms na diagnosis

class Appointment {
  final int? id;
  final int? patientId;
  final int? doctorId;
  final DateTime appointmentDate;
  final String status; // pending, confirmed, completed, cancelled
  final String? symptoms;
  final String? diagnosis;
  final String? notes;
  final DateTime? createdAt;
  final DateTime? updatedAt;
  
  // Patient info (from relationship)
  final String? patientName;
  final String? patientPhone;
  final String? patientNumber;
  
  // Doctor info (from relationship)
  final String? doctorName;
  final String? doctorSpecialization;
  
  Appointment({
    this.id,
    this.patientId,
    this.doctorId,
    required this.appointmentDate,
    required this.status,
    this.symptoms,
    this.diagnosis,
    this.notes,
    this.createdAt,
    this.updatedAt,
    this.patientName,
    this.patientPhone,
    this.patientNumber,
    this.doctorName,
    this.doctorSpecialization,
  });
  
  // ──────────────────────────────────────────────────────────
  // FROM JSON
  // ──────────────────────────────────────────────────────────
  factory Appointment.fromJson(Map<String, dynamic> json) {
    return Appointment(
      id: json['id'] as int?,
      patientId: json['patient_id'] as int?,
      doctorId: json['doctor_id'] as int?,
      appointmentDate: DateTime.parse(json['appointment_date'] as String),
      status: json['status'] as String? ?? 'pending',
      symptoms: json['symptoms'] as String?,
      diagnosis: json['diagnosis'] as String?,
      notes: json['notes'] as String?,
      createdAt: json['created_at'] != null 
          ? DateTime.parse(json['created_at'] as String) 
          : null,
      updatedAt: json['updated_at'] != null 
          ? DateTime.parse(json['updated_at'] as String) 
          : null,
      patientName: json['patient_name'] as String?,
      patientPhone: json['patient_phone'] as String?,
      patientNumber: json['patient_number'] as String?,
      doctorName: json['doctor_name'] as String?,
      doctorSpecialization: json['doctor_specialization'] as String?,
    );
  }
  
  // ──────────────────────────────────────────────────────────
  // TO JSON
  // ──────────────────────────────────────────────────────────
  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'patient_id': patientId,
      'doctor_id': doctorId,
      'appointment_date': appointmentDate.toIso8601String(),
      'status': status,
      'symptoms': symptoms,
      'diagnosis': diagnosis,
      'notes': notes,
      'created_at': createdAt?.toIso8601String(),
      'updated_at': updatedAt?.toIso8601String(),
    };
  }
  
  // ──────────────────────────────────────────────────────────
  // COPY WITH
  // ──────────────────────────────────────────────────────────
  Appointment copyWith({
    int? id,
    int? patientId,
    int? doctorId,
    DateTime? appointmentDate,
    String? status,
    String? symptoms,
    String? diagnosis,
    String? notes,
    DateTime? createdAt,
    DateTime? updatedAt,
    String? patientName,
    String? patientPhone,
    String? patientNumber,
    String? doctorName,
    String? doctorSpecialization,
  }) {
    return Appointment(
      id: id ?? this.id,
      patientId: patientId ?? this.patientId,
      doctorId: doctorId ?? this.doctorId,
      appointmentDate: appointmentDate ?? this.appointmentDate,
      status: status ?? this.status,
      symptoms: symptoms ?? this.symptoms,
      diagnosis: diagnosis ?? this.diagnosis,
      notes: notes ?? this.notes,
      createdAt: createdAt ?? this.createdAt,
      updatedAt: updatedAt ?? this.updatedAt,
      patientName: patientName ?? this.patientName,
      patientPhone: patientPhone ?? this.patientPhone,
      patientNumber: patientNumber ?? this.patientNumber,
      doctorName: doctorName ?? this.doctorName,
      doctorSpecialization: doctorSpecialization ?? this.doctorSpecialization,
    );
  }
  
  // ──────────────────────────────────────────────────────────
  // GET STATUS LABEL
  // ──────────────────────────────────────────────────────────
  String get statusLabel {
    switch (status.toLowerCase()) {
      case 'pending':
        return 'Inasubiri';
      case 'confirmed':
        return 'Imethibitishwa';
      case 'completed':
        return 'Imekamilika';
      case 'cancelled':
        return 'Imefutwa';
      default:
        return status;
    }
  }
  
  // ──────────────────────────────────────────────────────────
  // GET STATUS COLOR
  // ──────────────────────────────────────────────────────────
  String get statusColor {
    switch (status.toLowerCase()) {
      case 'pending':
        return '#F59E0B'; // Amber
      case 'confirmed':
        return '#3B82F6'; // Blue
      case 'completed':
        return '#10B981'; // Green
      case 'cancelled':
        return '#EF4444'; // Red
      default:
        return '#6B7280'; // Gray
    }
  }
}
