# Products Promotions API

This API allows you to get a list of products from the MyTheresa store, filtered by category and with discounts applied to certain products.

## Requirements

- Docker
- Docker Compose

## Installation and Execution

1. Clone the repository and navigate to the project directory:

   ```bash
   git clone https://github.com/woker21/BackLaravelTestCap
   cd BackLaravelTestCap

2. Build and launch containers with Docker:

   ```bash
   docker run -d -p 8000:80 restapi_php-app
3. The API will be available at:
   ```bash
   http://localhost:8000/api/products

You can filter products by category or by price using the category and priceLessThan parameters. For example:

   ```bash
   http://localhost:8000/api/products?category=boots&priceLessThan=10000
