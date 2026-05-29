import 'package:flutter/material.dart';
import '../../widgets/common/custom_app_bar.dart';
import '../../widgets/common/bottom_navigation.dart';

/// Shop Screen
/// 
/// Screen inayoonyesha bidhaa za duka.
/// Inajumuisha:
/// - List ya bidhaa
/// - Filter by category
/// - Search functionality
/// - Add to cart button

class ShopScreen extends StatelessWidget {
  const ShopScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: const CustomAppBar(
        title: 'Duka',
      ),
      body: SafeArea(
        child: Column(
          children: [
            // Search Bar
            _buildSearchBar(context),
            
            // Category Filter
            _buildCategoryFilter(context),
            
            // Products List
            Expanded(
              child: _buildProductsList(context),
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
          hintText: 'Tafuta bidhaa...',
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
            _buildCategoryChip(context, 'Dawa', false),
            const SizedBox(width: 8),
            _buildCategoryChip(context, 'Vitamins', false),
            const SizedBox(width: 8),
            _buildCategoryChip(context, 'Supplements', false),
            const SizedBox(width: 8),
            _buildCategoryChip(context, 'Personal Care', false),
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
        // TODO: Filter products
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
  
  Widget _buildProductsList(BuildContext context) {
    return GridView.builder(
      padding: const EdgeInsets.all(16),
      gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
        crossAxisCount: 2,
        childAspectRatio: 0.7,
        crossAxisSpacing: 16,
        mainAxisSpacing: 16,
      ),
      itemCount: 6,
      itemBuilder: (context, index) {
        return _buildProductCard(context, index);
      },
    );
  }
  
  Widget _buildProductCard(BuildContext context, int index) {
    return Card(
      child: InkWell(
        onTap: () {
          // TODO: Navigate to product details
        },
        borderRadius: BorderRadius.circular(12),
        child: Padding(
          padding: const EdgeInsets.all(12),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              // Product Image
              Container(
                height: 80,
                decoration: BoxDecoration(
                  color: Theme.of(context).colorScheme.primaryContainer,
                  borderRadius: BorderRadius.circular(8),
                ),
                child: const Icon(
                  Icons.medication,
                  size: 40,
                  color: Colors.white,
                ),
              ),
              const SizedBox(height: 12),
              // Product Name
              Text(
                _getProductName(index),
                style: const TextStyle(
                  fontWeight: FontWeight.w600,
                  fontSize: 14,
                ),
                maxLines: 2,
                overflow: TextOverflow.ellipsis,
              ),
              const SizedBox(height: 4),
              // Stock Status
              Row(
                children: [
                  Icon(
                    _isInStock(index) ? Icons.check_circle : Icons.warning,
                    size: 12,
                    color: _isInStock(index) ? Colors.green : Colors.orange,
                  ),
                  const SizedBox(width: 4),
                  Text(
                    _isInStock(index) ? 'In Stock' : 'Low Stock',
                    style: TextStyle(
                      fontSize: 10,
                      color: _isInStock(index) ? Colors.green : Colors.orange,
                    ),
                  ),
                ],
              ),
              const SizedBox(height: 8),
              // Price
              Text(
                _getProductPrice(index),
                style: TextStyle(
                  color: Theme.of(context).colorScheme.primary,
                  fontWeight: FontWeight.bold,
                  fontSize: 14,
                ),
              ),
              const Spacer(),
              // Add to Cart Button
              SizedBox(
                width: double.infinity,
                child: ElevatedButton(
                  onPressed: () {
                    // TODO: Add to cart
                  },
                  style: ElevatedButton.styleFrom(
                    padding: const EdgeInsets.symmetric(vertical: 8),
                  ),
                  child: const Text('Weka Kikapu'),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
  
  String _getProductName(int index) {
    switch (index % 6) {
      case 0:
        return 'Paracetamol 500mg';
      case 1:
        return 'Amoxicillin 250mg';
      case 2:
        return 'Vitamin C 1000mg';
      case 3:
        return 'Iron Supplements';
      case 4:
        return 'Cough Syrup';
      case 5:
        return 'Pain Relief Gel';
      default:
        return 'Product Name';
    }
  }
  
  String _getProductPrice(int index) {
    switch (index % 6) {
      case 0:
        return 'Tsh 5,000';
      case 1:
        return 'Tsh 15,000';
      case 2:
        return 'Tsh 8,000';
      case 3:
        return 'Tsh 12,000';
      case 4:
        return 'Tsh 10,000';
      case 5:
        return 'Tsh 7,000';
      default:
        return 'Tsh 0';
    }
  }
  
  bool _isInStock(int index) {
    return index % 3 != 0; // Every 3rd item is low stock
  }
}
