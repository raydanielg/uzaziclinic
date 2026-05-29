/// Blog Model
/// 
/// Model ya blog post inayowakilisha makala ya kliniki.
/// Inajumuisha:
/// - Blog details (title, content, excerpt)
/// - Author info
/// - Category
/// - Featured image
/// - Published date

class Blog {
  final int? id;
  final String title;
  final String? excerpt;
  final String? content;
  final String? featuredImage;
  final String? category;
  final String? authorName;
  final DateTime? publishedAt;
  final int? views;
  final bool? isFeatured;
  final DateTime? createdAt;
  final DateTime? updatedAt;
  
  Blog({
    this.id,
    required this.title,
    this.excerpt,
    this.content,
    this.featuredImage,
    this.category,
    this.authorName,
    this.publishedAt,
    this.views,
    this.isFeatured,
    this.createdAt,
    this.updatedAt,
  });
  
  // ──────────────────────────────────────────────────────────
  // FROM JSON
  // ──────────────────────────────────────────────────────────
  factory Blog.fromJson(Map<String, dynamic> json) {
    return Blog(
      id: json['id'] as int?,
      title: json['title'] as String,
      excerpt: json['excerpt'] as String?,
      content: json['content'] as String?,
      featuredImage: json['featured_image'] as String?,
      category: json['category'] as String?,
      authorName: json['author_name'] as String?,
      publishedAt: json['published_at'] != null 
          ? DateTime.parse(json['published_at'] as String) 
          : null,
      views: json['views'] as int?,
      isFeatured: json['is_featured'] as bool?,
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
      'title': title,
      'excerpt': excerpt,
      'content': content,
      'featured_image': featuredImage,
      'category': category,
      'author_name': authorName,
      'published_at': publishedAt?.toIso8601String(),
      'views': views,
      'is_featured': isFeatured,
      'created_at': createdAt?.toIso8601String(),
      'updated_at': updatedAt?.toIso8601String(),
    };
  }
  
  // ──────────────────────────────────────────────────────────
  // COPY WITH
  // ──────────────────────────────────────────────────────────
  Blog copyWith({
    int? id,
    String? title,
    String? excerpt,
    String? content,
    String? featuredImage,
    String? category,
    String? authorName,
    DateTime? publishedAt,
    int? views,
    bool? isFeatured,
    DateTime? createdAt,
    DateTime? updatedAt,
  }) {
    return Blog(
      id: id ?? this.id,
      title: title ?? this.title,
      excerpt: excerpt ?? this.excerpt,
      content: content ?? this.content,
      featuredImage: featuredImage ?? this.featuredImage,
      category: category ?? this.category,
      authorName: authorName ?? this.authorName,
      publishedAt: publishedAt ?? this.publishedAt,
      views: views ?? this.views,
      isFeatured: isFeatured ?? this.isFeatured,
      createdAt: createdAt ?? this.createdAt,
      updatedAt: updatedAt ?? this.updatedAt,
    );
  }
  
  // ──────────────────────────────────────────────────────────
  // GET FORMATTED DATE
  // ──────────────────────────────────────────────────────────
  String get formattedDate {
    if (publishedAt == null) return '';
    final months = [
      'Jan', 'Feb', 'Mac', 'Apr', 'Mei', 'Jun',
      'Jul', 'Ago', 'Sep', 'Okt', 'Nov', 'Des'
    ];
    return '${publishedAt!.day} ${months[publishedAt!.month - 1]} ${publishedAt!.year}';
  }
}
