/// Service Model
/// 
/// Model ya service inayowakilisha huduma za kliniki.
/// Inajumuisha:
/// - Service details (name, description, price)
/// - Service category
/// - Service image
/// - Service availability

class Service {
  final int? id;
  final String name;
  final String? description;
  final String? category;
  final double? price;
  final String? image;
  final int? duration; // in minutes
  final bool? isActive;
  final DateTime? createdAt;
  final DateTime? updatedAt;
  
  Service({
    this.id,
    required this.name,
    this.description,
    this.category,
    this.price,
    this.image,
    this.duration,
    this.isActive,
    this.createdAt,
    this.updatedAt,
  });
  
  // ──────────────────────────────────────────────────────────
  // FROM JSON
  // ──────────────────────────────────────────────────────────
  factory Service.fromJson(Map<String, dynamic> json) {
    return Service(
      id: json['id'] as int?,
      name: json['name'] as String,
      description: json['description'] as String?,
      category: json['category'] as String?,
      price: (json['price'] as num?)?.toDouble(),
      image: json['image'] as String?,
      duration: json['duration'] as int?,
      isActive: json['is_active'] as bool?,
      createdAt: json['created_at'] != null 
          ? DateTime.parse(json['created_at'] as String) 
          : null,
      updatedAt: json['updated_at'] != null 
          ? DateTime.parse(json['updated_at'] as String) 
          : null,
    );
  }
  
  // ──────────────────────────────────────────────────────────
  // TO JSON
  // ──────────────────────────────────────────────────────────
  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'name': name,
      'description': description,
      'category': category,
      'price': price,
      'image': image,
      'duration': duration,
      'is_active': isActive,
      'created_at': createdAt?.toIso8601String(),
      'updated_at': updatedAt?.toIso8601String(),
    };
  }
  
  // ──────────────────────────────────────────────────────────
  // COPY WITH
  // ──────────────────────────────────────────────────────────
  Service copyWith({
    int? id,
    String? name,
    String? description,
    String? category,
    double? price,
    String? image,
    int? duration,
    bool? isActive,
    DateTime? createdAt,
    DateTime? updatedAt,
  }) {
    return Service(
      id: id ?? this.id,
      name: name ?? this.name,
      description: description ?? this.description,
      category: category ?? this.category,
      price: price ?? this.price,
      image: image ?? this.image,
      duration: duration ?? this.duration,
      isActive: isActive ?? this.isActive,
      createdAt: createdAt ?? this.createdAt,
      updatedAt: updatedAt ?? this.updatedAt,
    );
  }
  
  // ──────────────────────────────────────────────────────────
  // GET FORMATTED PRICE
  // ──────────────────────────────────────────────────────────
  String get formattedPrice {
    if (price == null) return 'Tsh 0';
    return 'Tsh ${price!.toStringAsFixed(0).replaceAllMapped(
      RegExp(r'(\d{1,3})(?=(\d{3})+(?!\d))'),
      (Match m) => '${m[1]},',
    )}';
  }
}
