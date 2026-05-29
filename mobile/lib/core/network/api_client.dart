import 'dart:convert';
import 'package:http/http.dart' as http;
import '../constants/app_constants.dart';

/// API Client
/// 
/// Hii class inashughulikia mawasiliano na API server.
/// Inatumia http package kufanya requests.
/// Inajumuisha:
/// - GET, POST, PUT, DELETE methods
/// - Error handling
/// - Token authentication
/// - Timeout configuration

class ApiClient {
  final http.Client _client;
  final String _baseUrl;
  
  ApiClient({http.Client? client})
      : _client = client ?? http.Client(),
        _baseUrl = AppConstants.baseUrl;
  
  // ──────────────────────────────────────────────────────────
  // GET REQUEST
  // ──────────────────────────────────────────────────────────
  Future<http.Response> get(
    String endpoint, {
    Map<String, String>? headers,
    Map<String, dynamic>? queryParams,
  }) async {
    try {
      final uri = Uri.parse('$_baseUrl$endpoint').replace(
        queryParameters: queryParams?.map(
          (key, value) => MapEntry(key, value.toString()),
        ),
      );
      
      final response = await _client
          .get(
            uri,
            headers: _getHeaders(headers),
          )
          .timeout(
            const Duration(milliseconds: AppConstants.receiveTimeout),
          );
      
      return _handleResponse(response);
    } catch (e) {
      throw _handleError(e);
    }
  }
  
  // ──────────────────────────────────────────────────────────
  // POST REQUEST
  // ──────────────────────────────────────────────────────────
  Future<http.Response> post(
    String endpoint, {
    Map<String, String>? headers,
    Map<String, dynamic>? body,
  }) async {
    try {
      final uri = Uri.parse('$_baseUrl$endpoint');
      
      final response = await _client
          .post(
            uri,
            headers: _getHeaders(headers),
            body: body != null ? jsonEncode(body) : null,
          )
          .timeout(
            const Duration(milliseconds: AppConstants.sendTimeout),
          );
      
      return _handleResponse(response);
    } catch (e) {
      throw _handleError(e);
    }
  }
  
  // ──────────────────────────────────────────────────────────
  // PUT REQUEST
  // ──────────────────────────────────────────────────────────
  Future<http.Response> put(
    String endpoint, {
    Map<String, String>? headers,
    Map<String, dynamic>? body,
  }) async {
    try {
      final uri = Uri.parse('$_baseUrl$endpoint');
      
      final response = await _client
          .put(
            uri,
            headers: _getHeaders(headers),
            body: body != null ? jsonEncode(body) : null,
          )
          .timeout(
            const Duration(milliseconds: AppConstants.sendTimeout),
          );
      
      return _handleResponse(response);
    } catch (e) {
      throw _handleError(e);
    }
  }
  
  // ──────────────────────────────────────────────────────────
  // DELETE REQUEST
  // ──────────────────────────────────────────────────────────
  Future<http.Response> delete(
    String endpoint, {
    Map<String, String>? headers,
  }) async {
    try {
      final uri = Uri.parse('$_baseUrl$endpoint');
      
      final response = await _client
          .delete(
            uri,
            headers: _getHeaders(headers),
          )
          .timeout(
            const Duration(milliseconds: AppConstants.sendTimeout),
          );
      
      return _handleResponse(response);
    } catch (e) {
      throw _handleError(e);
    }
  }
  
  // ──────────────────────────────────────────────────────────
  // GET HEADERS WITH AUTH TOKEN
  // ──────────────────────────────────────────────────────────
  Map<String, String> _getHeaders(Map<String, String>? customHeaders) {
    final headers = {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    };
    
    // Add custom headers if provided
    if (customHeaders != null) {
      headers.addAll(customHeaders);
    }
    
    return headers;
  }
  
  // ──────────────────────────────────────────────────────────
  // HANDLE RESPONSE
  // ──────────────────────────────────────────────────────────
  http.Response _handleResponse(http.Response response) {
    return response;
  }
  
  // ──────────────────────────────────────────────────────────
  // HANDLE ERROR
  // ──────────────────────────────────────────────────────────
  Exception _handleError(dynamic error) {
    if (error is http.ClientException) {
      return Exception('Tatizo la mtandao. Tafadhali angalia muunganisho wako.');
    }
    
    return Exception('Hitilafu iliibuka: $error');
  }
}
