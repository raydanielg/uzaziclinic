/// Product Model
/// 
/// Model ya product inayowakilisha bidhaa za duka.
/// Inajumuisha:
/// - Product details (name, description, price)
/// - Category
/// - Stock quantity
/// - Product image
/// - Expiry date

class Product {
  final int? id;
  final String name;
  final String? description;
  final String? category;
  final double price;
  final int quantity;
  final String? image;
  final DateTime? expiryDate;
  final bool? isActive;
  final DateTime? createdAt;
  final DateTime? updatedAt;
  
  Product({
    this.id,
    required this.name,
    this.description,
    this.category,
    required this.price,
    required this.quantity,
    this.image,
    this.expiryDate,
    this.isActive,
    this.createdAt,
    this.updatedAt,
  });
  
  // ──────────────────────────────────────────────────────────
  // FROM JSON
  // ──────────────────────────────────────────────────────────
  factory Product.fromJson(Map<String, dynamic> json) {
    return Product(
      id: json['id'] as int?,
      name: json['name'] as String,
      description: json['description'] as String?,
      category: json['category'] as String?,
      price: (json['price'] as num).toDouble(),
      quantity: json['quantity'] as int,
      image: json['image'] as String?,
      expiryDate: json['expiry_date'] != null 
          ? DateTime.parse(json['expiry_date'] as String) 
          : null,
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
      'quantity': quantity,
      'image': image,
      'expiry_date': expiryDate?.toIso8601String(),
      'is_active': isActive,
      'created_at': createdAt?.toIso8601String(),
      'updated_at': updatedAt?.toIso8601String(),
    };
  }
  
  // ──────────────────────────────────────────────────────────
  // COPY WITH
  // ──────────────────────────────────────────────────────────
  Product copyWith({
    int? id,
    String? name,
    String? description,
    String? category,
    double? price,
    int? quantity,
    String? image,
    DateTime? expiryDate,
    bool? isActive,
    DateTime? createdAt,
    DateTime? updatedAt,
  }) {
    return Product(
      id: id ?? this.id,
      name: name ?? this.name,
      description: description ?? this.description,
      category: category ?? this.category,
      price: price ?? this.price,
      quantity: quantity ?? this.quantity,
      image: image ?? this.image,
      expiryDate: expiryDate ?? this.expiryDate,
      isActive: isActive ?? this.isActive,
      createdAt: createdAt ?? this.createdAt,
      updatedAt: updatedAt ?? this.updatedAt,
    );
  }
  
  // ──────────────────────────────────────────────────────────
  // GET FORMATTED PRICE
  // ──────────────────────────────────────────────────────────
  String get formattedPrice {
    return 'Tsh ${price.toStringAsFixed(0).replaceAllMapped(
      RegExp(r'(\d{1,3})(?=(\d{3})+(?!\d))'),
      (Match m) => '${m[1]},',
    )}';
  }
  
  // ──────────────────────────────────────────────────────────
  // IS IN STOCK
  // ──────────────────────────────────────────────────────────
  bool get isInStock => quantity > 0;
  
  // ──────────────────────────────────────────────────────────
  // IS EXPIRED
  // ──────────────────────────────────────────────────────────
  bool get isExpired {
    if (expiryDate == null) return false;
    return expiryDate!.isBefore(DateTime.now());
  }
  
  // ──────────────────────────────────────────────────────────
  // IS LOW STOCK
  // ──────────────────────────────────────────────────────────
  bool get isLowStock => quantity > 0 && quantity <= 10;
}
