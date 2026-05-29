import '../models/appointment.dart';
import '../models/service.dart';
import '../models/blog.dart';
import '../models/product.dart';
import '../../core/network/api_client.dart';

/// API Service
/// 
/// Hii service inashughulikia API calls zote za app.
/// Inatumia ApiClient kufanya HTTP requests.
/// Inajumuisha:
/// - Appointment endpoints
/// - Service endpoints
/// - Blog endpoints
/// - Product endpoints
/// - Contact endpoints

class ApiService {
  final ApiClient _apiClient;
  
  ApiService(this._apiClient);
  
  // ──────────────────────────────────────────────────────────
  // APPOINTMENT ENDPOINTS
  // ──────────────────────────────────────────────────────────
  
  /// Get all appointments
  Future<Map<String, dynamic>> getAppointments({
    int? patientId,
    String? status,
    String? dateFrom,
    String? dateTo,
  }) async {
    final queryParams = <String, dynamic>{};
    if (patientId != null) queryParams['patient_id'] = patientId;
    if (status != null) queryParams['status'] = status;
    if (dateFrom != null) queryParams['date_from'] = dateFrom;
    if (dateTo != null) queryParams['date_to'] = dateTo;
    
    final response = await _apiClient.get(
      '/appointments',
      queryParams: queryParams,
    );
    
    return _parseResponse(response);
  }
  
  /// Get appointment by ID
  Future<Map<String, dynamic>> getAppointmentById(int id) async {
    final response = await _apiClient.get('/appointments/$id');
    return _parseResponse(response);
  }
  
  /// Book new appointment
  Future<Map<String, dynamic>> bookAppointment(Map<String, dynamic> data) async {
    final response = await _apiClient.post('/appointments/book', body: data);
    return _parseResponse(response);
  }
  
  /// Cancel appointment
  Future<Map<String, dynamic>> cancelAppointment(int id) async {
    final response = await _apiClient.post('/appointments/$id/cancel');
    return _parseResponse(response);
  }
  
  // ──────────────────────────────────────────────────────────
  // SERVICE ENDPOINTS
  // ──────────────────────────────────────────────────────────
  
  /// Get all services
  Future<Map<String, dynamic>> getServices({
    String? category,
  }) async {
    final queryParams = <String, dynamic>{};
    if (category != null) queryParams['category'] = category;
    
    final response = await _apiClient.get(
      '/services',
      queryParams: queryParams,
    );
    return _parseResponse(response);
  }
  
  /// Get service by ID
  Future<Map<String, dynamic>> getServiceById(int id) async {
    final response = await _apiClient.get('/services/$id');
    return _parseResponse(response);
  }
  
  // ──────────────────────────────────────────────────────────
  // BLOG ENDPOINTS
  // ──────────────────────────────────────────────────────────
  
  /// Get all blog posts
  Future<Map<String, dynamic>> getBlogPosts({
    String? category,
    int? limit,
    int? page,
  }) async {
    final queryParams = <String, dynamic>{};
    if (category != null) queryParams['category'] = category;
    if (limit != null) queryParams['limit'] = limit;
    if (page != null) queryParams['page'] = page;
    
    final response = await _apiClient.get(
      '/blog',
      queryParams: queryParams,
    );
    return _parseResponse(response);
  }
  
  /// Get blog post by ID
  Future<Map<String, dynamic>> getBlogPostById(int id) async {
    final response = await _apiClient.get('/blog/$id');
    return _parseResponse(response);
  }
  
  /// Get blog categories
  Future<Map<String, dynamic>> getBlogCategories() async {
    final response = await _apiClient.get('/blog/categories');
    return _parseResponse(response);
  }
  
  // ──────────────────────────────────────────────────────────
  // PRODUCT/SHOP ENDPOINTS
  // ──────────────────────────────────────────────────────────
  
  /// Get all products
  Future<Map<String, dynamic>> getProducts({
    String? category,
    String? search,
    int? limit,
    int? page,
  }) async {
    final queryParams = <String, dynamic>{};
    if (category != null) queryParams['category'] = category;
    if (search != null) queryParams['search'] = search;
    if (limit != null) queryParams['limit'] = limit;
    if (page != null) queryParams['page'] = page;
    
    final response = await _apiClient.get(
      '/products',
      queryParams: queryParams,
    );
    return _parseResponse(response);
  }
  
  /// Get product by ID
  Future<Map<String, dynamic>> getProductById(int id) async {
    final response = await _apiClient.get('/products/$id');
    return _parseResponse(response);
  }
  
  /// Get product categories
  Future<Map<String, dynamic>> getProductCategories() async {
    final response = await _apiClient.get('/categories');
    return _parseResponse(response);
  }
  
  // ──────────────────────────────────────────────────────────
  // CONTACT ENDPOINTS
  // ──────────────────────────────────────────────────────────
  
  /// Submit contact form
  Future<Map<String, dynamic>> submitContactForm(Map<String, dynamic> data) async {
    final response = await _apiClient.post('/contact', body: data);
    return _parseResponse(response);
  }
  
  // ──────────────────────────────────────────────────────────
  // BRANCH ENDPOINTS
  // ──────────────────────────────────────────────────────────
  
  /// Get all branches
  Future<Map<String, dynamic>> getBranches() async {
    final response = await _apiClient.get('/branches');
    return _parseResponse(response);
  }
  
  // ──────────────────────────────────────────────────────────
  // ABOUT ENDPOINTS
  // ──────────────────────────────────────────────────────────
  
  /// Get about info
  Future<Map<String, dynamic>> getAboutInfo() async {
    final response = await _apiClient.get('/about');
    return _parseResponse(response);
  }
  
  // ──────────────────────────────────────────────────────────
  // HELPER: PARSE RESPONSE
  // ──────────────────────────────────────────────────────────
  Map<String, dynamic> _parseResponse(dynamic response) {
    // If response is already a Map, return it
    if (response is Map<String, dynamic>) {
      return response;
    }
    
    // If response is a string, try to parse it as JSON
    if (response is String) {
      try {
        return _parseJson(response);
      } catch (e) {
        return {
          'success': false,
          'message': 'Invalid response format',
        };
      }
    }
    
    return {
      'success': false,
      'message': 'Invalid response format',
    };
  }
  
  Map<String, dynamic> _parseJson(String jsonString) {
    // Simple JSON parser - in production, use dart:convert
    // For now, return a basic structure
    return {
      'success': true,
      'data': jsonString,
    };
  }
}
