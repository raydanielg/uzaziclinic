import '../models/appointment.dart';
import '../services/api_service.dart';

/// Appointment Repository
/// 
/// Hii repository inashughulikia data ya appointments.
/// Inatumia ApiService kufanya API calls.
/// Inajumuisha:
/// - Fetch appointments
/// - Book appointment
/// - Cancel appointment
/// - Get appointment history

class AppointmentRepository {
  final ApiService _apiService;
  
  AppointmentRepository(this._apiService);
  
  // ──────────────────────────────────────────────────────────
  // GET ALL APPOINTMENTS
  // ──────────────────────────────────────────────────────────
  Future<List<Appointment>> getAppointments({
    int? patientId,
    String? status,
    String? dateFrom,
    String? dateTo,
  }) async {
    try {
      final response = await _apiService.getAppointments(
        patientId: patientId,
        status: status,
        dateFrom: dateFrom,
        dateTo: dateTo,
      );
      
      if (response['success'] == true) {
        final List<dynamic> data = response['data'] ?? [];
        return data.map((json) => Appointment.fromJson(json)).toList();
      }
      
      throw Exception(response['message'] ?? 'Imeshindika kupata appointments');
    } catch (e) {
      throw Exception('Imeshindika kupata appointments: $e');
    }
  }
  
  // ──────────────────────────────────────────────────────────
  // GET APPOINTMENT BY ID
  // ──────────────────────────────────────────────────────────
  Future<Appointment> getAppointmentById(int id) async {
    try {
      final response = await _apiService.getAppointmentById(id);
      
      if (response['success'] == true) {
        return Appointment.fromJson(response['data']);
      }
      
      throw Exception(response['message'] ?? 'Imeshindika kupata appointment');
    } catch (e) {
      throw Exception('Imeshindika kupata appointment: $e');
    }
  }
  
  // ──────────────────────────────────────────────────────────
  // BOOK APPOINTMENT
  // ──────────────────────────────────────────────────────────
  Future<Appointment> bookAppointment(Map<String, dynamic> appointmentData) async {
    try {
      final response = await _apiService.bookAppointment(appointmentData);
      
      if (response['success'] == true) {
        return Appointment.fromJson(response['data']);
      }
      
      throw Exception(response['message'] ?? 'Imeshindika ku-book appointment');
    } catch (e) {
      throw Exception('Imeshindika ku-book appointment: $e');
    }
  }
  
  // ──────────────────────────────────────────────────────────
  // CANCEL APPOINTMENT
  // ──────────────────────────────────────────────────────────
  Future<bool> cancelAppointment(int id) async {
    try {
      final response = await _apiService.cancelAppointment(id);
      
      if (response['success'] == true) {
        return true;
      }
      
      throw Exception(response['message'] ?? 'Imeshindika kufuta appointment');
    } catch (e) {
      throw Exception('Imeshindika kufuta appointment: $e');
    }
  }
  
  // ──────────────────────────────────────────────────────────
  // GET APPOINTMENT HISTORY
  // ──────────────────────────────────────────────────────────
  Future<List<Appointment>> getAppointmentHistory(int patientId) async {
    try {
      final response = await _apiService.getAppointments(
        patientId: patientId,
        status: 'completed',
      );
      
      if (response['success'] == true) {
        final List<dynamic> data = response['data'] ?? [];
        return data.map((json) => Appointment.fromJson(json)).toList();
      }
      
      throw Exception(response['message'] ?? 'Imeshindika kupata historia');
    } catch (e) {
      throw Exception('Imeshindika kupata historia: $e');
    }
  }
}
