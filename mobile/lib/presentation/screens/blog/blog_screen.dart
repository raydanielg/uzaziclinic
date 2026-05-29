import 'package:flutter/material.dart';
import '../../widgets/common/custom_app_bar.dart';
import '../../widgets/common/bottom_navigation.dart';

/// Blog Screen
/// 
/// Screen inayoonyesha makala za afya.
/// Inajumuisha:
/// - List ya blog posts
/// - Filter by category
/// - Featured posts
/// - Blog detail view

class BlogScreen extends StatelessWidget {
  const BlogScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: const CustomAppBar(
        title: 'Blog ya Afya',
      ),
      body: SafeArea(
        child: Column(
          children: [
            // Search Bar
            _buildSearchBar(context),
            
            // Category Filter
            _buildCategoryFilter(context),
            
            // Blog Posts List
            Expanded(
              child: _buildBlogList(context),
            ),
          ],
        ),
      ),
      bottomNavigationBar: const BottomNavigation(),
    );
  }
  
  Widget _buildSearchBar(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.all(16),
      child: TextField(
        decoration: InputDecoration(
          hintText: 'Tafuta makala...',
          prefixIcon: const Icon(Icons.search),
          border: OutlineInputBorder(
            borderRadius: BorderRadius.circular(8),
          ),
        ),
      ),
    );
  }
  
  Widget _buildCategoryFilter(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 12),
      child: SingleChildScrollView(
        scrollDirection: Axis.horizontal,
        padding: const EdgeInsets.symmetric(horizontal: 16),
        child: Row(
          children: [
            _buildCategoryChip(context, 'Zote', true),
            const SizedBox(width: 8),
            _buildCategoryChip(context, 'Mama na Mtoto', false),
            const SizedBox(width: 8),
            _buildCategoryChip(context, ' lishe', false),
            const SizedBox(width: 8),
            _buildCategoryChip(context, 'Maradhi', false),
            const SizedBox(width: 8),
            _buildCategoryChip(context, 'Afya ya Akili', false),
          ],
        ),
      ),
    );
  }
  
  Widget _buildCategoryChip(BuildContext context, String label, bool isSelected) {
    return FilterChip(
      label: Text(label),
      selected: isSelected,
      onSelected: (selected) {
        // TODO: Filter blog posts
      },
      backgroundColor: Colors.grey[200],
      selectedColor: Theme.of(context).colorScheme.primaryContainer,
      labelStyle: TextStyle(
        color: isSelected 
            ? Theme.of(context).colorScheme.primary 
            : Colors.grey[700],
      ),
    );
  }
  
  Widget _buildBlogList(BuildContext context) {
    return ListView.builder(
      padding: const EdgeInsets.all(16),
      itemCount: 5,
      itemBuilder: (context, index) {
        return _buildBlogCard(context, index);
      },
    );
  }
  
  Widget _buildBlogCard(BuildContext context, int index) {
    return Card(
      margin: const EdgeInsets.only(bottom: 16),
      child: InkWell(
        onTap: () {
          // TODO: Navigate to blog detail
        },
        borderRadius: BorderRadius.circular(12),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Featured Image
            Container(
              height: 150,
              decoration: BoxDecoration(
                color: Theme.of(context).colorScheme.primaryContainer,
                borderRadius: const BorderRadius.vertical(
                  top: Radius.circular(12),
                ),
              ),
              child: const Icon(
                Icons.article,
                size: 60,
                color: Colors.white,
              ),
            ),
            Padding(
              padding: const EdgeInsets.all(16),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  // Category and Date
                  Row(
                    children: [
                      Container(
                        padding: const EdgeInsets.symmetric(
                          horizontal: 8,
                          vertical: 4,
                        ),
                        decoration: BoxDecoration(
                          color: Theme.of(context).colorScheme.primaryContainer,
                          borderRadius: BorderRadius.circular(12),
                        ),
                        child: Text(
                          _getCategory(index),
                          style: TextStyle(
                            fontSize: 11,
                            color: Theme.of(context).colorScheme.primary,
                          ),
                        ),
                      ),
                      const SizedBox(width: 8),
                      const Text(
                        '24 Mei 2026',
                        style: TextStyle(
                          fontSize: 12,
                          color: Colors.grey,
                        ),
                      ),
                    ],
                  ),
                  const SizedBox(height: 12),
                  // Title
                  Text(
                    _getBlogTitle(index),
                    style: const TextStyle(
                      fontSize: 16,
                      fontWeight: FontWeight.bold,
                    ),
                    maxLines: 2,
                    overflow: TextOverflow.ellipsis,
                  ),
                  const SizedBox(height: 8),
                  // Excerpt
                  Text(
                    _getBlogExcerpt(index),
                    style: const TextStyle(
                      fontSize: 14,
                      color: Colors.grey,
                    ),
                    maxLines: 3,
                    overflow: TextOverflow.ellipsis,
                  ),
                  const SizedBox(height: 12),
                  // Author and Views
                  Row(
                    children: [
                      const Icon(
                        Icons.person,
                        size: 16,
                        color: Colors.grey,
                      ),
                      const SizedBox(width: 4),
                      const Text(
                        'Dkt. Issa',
                        style: TextStyle(
                          fontSize: 12,
                          color: Colors.grey,
                        ),
                      ),
                      const SizedBox(width: 16),
                      const Icon(
                        Icons.visibility,
                        size: 16,
                        color: Colors.grey,
                      ),
                      const SizedBox(width: 4),
                      Text(
                        '${(index + 1) * 123} views',
                        style: const TextStyle(
                          fontSize: 12,
                          color: Colors.grey,
                        ),
                      ),
                    ],
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
  
  String _getCategory(int index) {
    switch (index % 3) {
      case 0:
        return 'Mama na Mtoto';
      case 1:
        return ' lishe';
      case 2:
        return 'Maradhi';
      default:
        return 'Afya';
    }
  }
  
  String _getBlogTitle(int index) {
    switch (index % 5) {
      case 0:
        return 'Jinsi ya Kudumisha Afya ya Mama na Mtoto';
      case 1:
        return ' lishe Bora kwa Watoto Wadogo';
      case 2:
        return 'Kuhusu Malaria na Jinsi ya Kuepuka';
      case 3:
        return 'Afya ya Akili: Jinsi ya Kupumua Vizuri';
      case 4:
        return 'Vitamins Vinavyohitajika na Mwili';
      default:
        return 'Makala ya Afya';
    }
  }
  
  String _getBlogExcerpt(int index) {
    switch (index % 5) {
      case 0:
        return 'Jifunze kuhusu afya ya mama na mtoto, pamoja na namna ya kudumisha afya nzuri wakati wa ujauzito na baada ya kujifungua...';
      case 1:
        return ' lishe bora ni muhimu kwa ukuaji wa mtoto. Jifunze kuhusu chakula cha kutosha na lishe bora kwa watoto wadogo...';
      case 2:
        return 'Malaria ni moja ya maradhi hatari nchini Tanzania. Jifunze kuhusu jinsi ya kuepuka malaria na matibabu yake...';
      case 3:
        return 'Afya ya akili ni muhimu kwa maisha yako yote. Jifunze kuhusu jinsi ya kupumua vizuri na kudumisha afya ya akili...';
      case 4:
        return 'Vitamins ni muhimu kwa afya ya mwili. Jifunze kuhusu vitamins zinazohitajika na chanzo chake...';
      default:
        return 'Soma zaidi kuhusu afya na maisha yenye afya...';
    }
  }
}
