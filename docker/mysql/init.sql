DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS product_metadata_fields;

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  sku VARCHAR(64) NOT NULL UNIQUE,
  product_type VARCHAR(50) NOT NULL,
  name JSON NOT NULL,
  description JSON NULL,
  metadata JSON NULL,
  price DECIMAL(10,2) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CHECK (JSON_VALID(name)),
  CHECK (description IS NULL OR JSON_VALID(description)),
  CHECK (metadata IS NULL OR JSON_VALID(metadata))
);

CREATE TABLE product_metadata_fields (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_type VARCHAR(50) NOT NULL,
  field_key VARCHAR(100) NOT NULL,
  label JSON NOT NULL,
  value_type VARCHAR(30) NOT NULL DEFAULT 'text',
  is_required TINYINT(1) NOT NULL DEFAULT 0,
  sort_order INT NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY ux_type_field (product_type, field_key),
  CHECK (JSON_VALID(label))
);

INSERT INTO products (sku, product_type, name, description, metadata, price)
VALUES
  (
    'LAP-001',
    'electronics',
    JSON_OBJECT('en', 'Gaming Laptop', 'it', 'Laptop da Gaming'),
    JSON_OBJECT('en', 'High-performance laptop for gaming and development', 'it', 'Laptop ad alte prestazioni per gaming e sviluppo'),
    JSON_OBJECT(
      'brand', JSON_OBJECT('en', 'AstraTech', 'it', 'AstraTech'),
      'made_in', JSON_OBJECT('en', 'Taiwan', 'it', 'Taiwan'),
      'color', JSON_OBJECT('en', 'black', 'it', 'nero'),
      'material', JSON_OBJECT('en', 'aluminum', 'it', 'alluminio'),
      'height', JSON_OBJECT('en', '2.2 cm', 'it', '2.2 cm'),
      'width', JSON_OBJECT('en', '35.8 cm', 'it', '35.8 cm'),
      'depth', JSON_OBJECT('en', '24.5 cm', 'it', '24.5 cm'),
      'weight', JSON_OBJECT('en', '2.3kg', 'it', '2.3kg'),
      'screen_size', JSON_OBJECT('en', '15.6 inch', 'it', '15.6 pollici'),
      'os', JSON_OBJECT('en', 'Windows 11 Pro', 'it', 'Windows 11 Pro'),
      'cpu', JSON_OBJECT('en', 'Intel Core i7', 'it', 'Intel Core i7'),
      'ram', JSON_OBJECT('en', '32GB', 'it', '32GB'),
      'storage', JSON_OBJECT('en', '1TB SSD', 'it', '1TB SSD'),
      'coating', JSON_OBJECT('en', 'anti-fingerprint', 'it', 'anti impronta')
    ),
    1499.99
  ),
  (
    'KEY-001',
    'accessory',
    JSON_OBJECT('en', 'Mechanical Keyboard', 'it', 'Tastiera Meccanica'),
    JSON_OBJECT('en', 'RGB mechanical keyboard with blue switches', 'it', 'Tastiera meccanica RGB con switch blu'),
    JSON_OBJECT(
      'brand', JSON_OBJECT('en', 'KeyForge', 'it', 'KeyForge'),
      'made_in', JSON_OBJECT('en', 'China', 'it', 'Cina'),
      'color', JSON_OBJECT('en', 'white', 'it', 'bianco'),
      'material', JSON_OBJECT('en', 'ABS plastic', 'it', 'plastica ABS'),
      'height', JSON_OBJECT('en', '3.8 cm', 'it', '3.8 cm'),
      'width', JSON_OBJECT('en', '35.0 cm', 'it', '35.0 cm'),
      'depth', JSON_OBJECT('en', '12.0 cm', 'it', '12.0 cm'),
      'layout', JSON_OBJECT('en', 'TKL', 'it', 'TKL'),
      'switch_type', JSON_OBJECT('en', 'blue switches', 'it', 'switch blu'),
      'connectivity', JSON_OBJECT('en', 'USB-C wired', 'it', 'cablata USB-C'),
      'weight', JSON_OBJECT('en', '850g', 'it', '850g'),
      'coating', JSON_OBJECT('en', 'matte finish', 'it', 'finitura opaca')
    ),
    119.90
  ),
  (
    'TSH-001',
    'apparel',
    JSON_OBJECT('en', 'Cotton T-Shirt', 'it', 'Maglietta di Cotone'),
    JSON_OBJECT('en', 'Soft cotton shirt for everyday use', 'it', 'Maglietta morbida in cotone per uso quotidiano'),
    JSON_OBJECT(
      'brand', JSON_OBJECT('en', 'UrbanThread', 'it', 'UrbanThread'),
      'made_in', JSON_OBJECT('en', 'Italy', 'it', 'Italia'),
      'color', JSON_OBJECT('en', 'navy', 'it', 'blu navy'),
      'material', JSON_OBJECT('en', 'cotton', 'it', 'cotone'),
      'size', JSON_OBJECT('en', 'M', 'it', 'M'),
      'fit', JSON_OBJECT('en', 'regular', 'it', 'regolare'),
      'height', JSON_OBJECT('en', '72 cm', 'it', '72 cm'),
      'width', JSON_OBJECT('en', '52 cm', 'it', '52 cm'),
      'depth', JSON_OBJECT('en', '0.3 cm', 'it', '0.3 cm'),
      'closure_type', JSON_OBJECT('en', 'pullover', 'it', 'senza chiusura'),
      'strap_type', JSON_OBJECT('en', 'none', 'it', 'nessuna spallina'),
      'coating', JSON_OBJECT('en', 'enzyme wash', 'it', 'lavaggio enzimatico')
    ),
    24.90
  ),
  (
    'MUG-001',
    'home',
    JSON_OBJECT('en', 'Ceramic Mug', 'it', 'Tazza in Ceramica'),
    JSON_OBJECT('en', 'Dishwasher-safe ceramic coffee mug', 'it', 'Tazza da caffe in ceramica lavabile in lavastoviglie'),
    JSON_OBJECT(
      'brand', JSON_OBJECT('en', 'CasaLine', 'it', 'CasaLine'),
      'made_in', JSON_OBJECT('en', 'Portugal', 'it', 'Portogallo'),
      'color', JSON_OBJECT('en', 'green', 'it', 'verde'),
      'material', JSON_OBJECT('en', 'ceramic', 'it', 'ceramica'),
      'height', JSON_OBJECT('en', '9.8 cm', 'it', '9.8 cm'),
      'width', JSON_OBJECT('en', '12.1 cm', 'it', '12.1 cm'),
      'depth', JSON_OBJECT('en', '8.6 cm', 'it', '8.6 cm'),
      'capacity', JSON_OBJECT('en', '350ml', 'it', '350ml'),
      'weight', JSON_OBJECT('en', '300g', 'it', '300g'),
      'coating', JSON_OBJECT('en', 'glazed', 'it', 'smaltata')
    ),
    14.50
  ),
  (
    'RUN-001',
    'footwear',
    JSON_OBJECT('en', 'Running Shoes', 'it', 'Scarpe da Corsa'),
    JSON_OBJECT('en', 'Breathable shoes for daily training', 'it', 'Scarpe traspiranti per allenamento quotidiano'),
    JSON_OBJECT(
      'brand', JSON_OBJECT('en', 'StrideLab', 'it', 'StrideLab'),
      'made_in', JSON_OBJECT('en', 'Vietnam', 'it', 'Vietnam'),
      'color', JSON_OBJECT('en', 'red', 'it', 'rosso'),
      'material', JSON_OBJECT('en', 'mesh', 'it', 'rete'),
      'size', JSON_OBJECT('en', '42', 'it', '42'),
      'height', JSON_OBJECT('en', '11.5 cm', 'it', '11.5 cm'),
      'width', JSON_OBJECT('en', '10.1 cm', 'it', '10.1 cm'),
      'depth', JSON_OBJECT('en', '29.0 cm', 'it', '29.0 cm'),
      'weight', JSON_OBJECT('en', '260g', 'it', '260g'),
      'closure_type', JSON_OBJECT('en', 'lace-up', 'it', 'stringhe'),
      'strap_type', JSON_OBJECT('en', 'heel support', 'it', 'supporto tallone'),
      'coating', JSON_OBJECT('en', 'water-repellent', 'it', 'idrorepellente')
    ),
    89.99
  ),
  (
    'LAP-002',
    'electronics',
    JSON_OBJECT('en', 'Ultrabook Pro', 'it', 'Ultrabook Pro'),
    JSON_OBJECT('en', 'Lightweight laptop for office and travel', 'it', 'Laptop leggero per ufficio e viaggio'),
    JSON_OBJECT(
      'brand', JSON_OBJECT('en', 'NovaCompute', 'it', 'NovaCompute'),
      'made_in', JSON_OBJECT('en', 'South Korea', 'it', 'Corea del Sud'),
      'color', JSON_OBJECT('en', 'silver', 'it', 'argento'),
      'material', JSON_OBJECT('en', 'aluminum', 'it', 'alluminio'),
      'height', JSON_OBJECT('en', '1.6 cm', 'it', '1.6 cm'),
      'width', JSON_OBJECT('en', '31.4 cm', 'it', '31.4 cm'),
      'depth', JSON_OBJECT('en', '22.1 cm', 'it', '22.1 cm'),
      'weight', JSON_OBJECT('en', '1.2kg', 'it', '1.2kg'),
      'screen_size', JSON_OBJECT('en', '14 inch', 'it', '14 pollici'),
      'os', JSON_OBJECT('en', 'Ubuntu 24.04 LTS', 'it', 'Ubuntu 24.04 LTS'),
      'cpu', JSON_OBJECT('en', 'AMD Ryzen 7', 'it', 'AMD Ryzen 7'),
      'ram', JSON_OBJECT('en', '16GB', 'it', '16GB'),
      'storage', JSON_OBJECT('en', '512GB SSD', 'it', '512GB SSD'),
      'coating', JSON_OBJECT('en', 'anti-glare', 'it', 'antiriflesso')
    ),
    999.00
  ),
  (
    'KEY-002',
    'accessory',
    JSON_OBJECT('en', 'Wireless Mouse', 'it', 'Mouse Wireless'),
    JSON_OBJECT('en', 'Ergonomic mouse with silent click buttons', 'it', 'Mouse ergonomico con tasti silenziosi'),
    JSON_OBJECT(
      'brand', JSON_OBJECT('en', 'ClickPoint', 'it', 'ClickPoint'),
      'made_in', JSON_OBJECT('en', 'Malaysia', 'it', 'Malesia'),
      'color', JSON_OBJECT('en', 'black', 'it', 'nero'),
      'material', JSON_OBJECT('en', 'polycarbonate', 'it', 'policarbonato'),
      'height', JSON_OBJECT('en', '4.1 cm', 'it', '4.1 cm'),
      'width', JSON_OBJECT('en', '6.6 cm', 'it', '6.6 cm'),
      'depth', JSON_OBJECT('en', '11.8 cm', 'it', '11.8 cm'),
      'layout', JSON_OBJECT('en', 'right-handed', 'it', 'destro'),
      'connectivity', JSON_OBJECT('en', '2.4G wireless', 'it', 'wireless 2.4G'),
      'dpi', JSON_OBJECT('en', '1600', 'it', '1600'),
      'weight', JSON_OBJECT('en', '95g', 'it', '95g'),
      'coating', JSON_OBJECT('en', 'soft-touch', 'it', 'soft touch')
    ),
    39.90
  ),
  (
    'TSH-002',
    'apparel',
    JSON_OBJECT('en', 'Performance Hoodie', 'it', 'Felpa Tecnica'),
    JSON_OBJECT('en', 'Warm hoodie for outdoor activities', 'it', 'Felpa calda per attivita all aperto'),
    JSON_OBJECT(
      'brand', JSON_OBJECT('en', 'PeakWear', 'it', 'PeakWear'),
      'made_in', JSON_OBJECT('en', 'Turkey', 'it', 'Turchia'),
      'color', JSON_OBJECT('en', 'charcoal', 'it', 'antracite'),
      'material', JSON_OBJECT('en', 'polyester blend', 'it', 'misto poliestere'),
      'size', JSON_OBJECT('en', 'L', 'it', 'L'),
      'fit', JSON_OBJECT('en', 'slim', 'it', 'aderente'),
      'height', JSON_OBJECT('en', '74 cm', 'it', '74 cm'),
      'width', JSON_OBJECT('en', '56 cm', 'it', '56 cm'),
      'depth', JSON_OBJECT('en', '1.1 cm', 'it', '1.1 cm'),
      'closure_type', JSON_OBJECT('en', 'zipper', 'it', 'zip'),
      'strap_type', JSON_OBJECT('en', 'none', 'it', 'nessuna spallina'),
      'coating', JSON_OBJECT('en', 'fleece lining', 'it', 'interno felpato')
    ),
    59.00
  ),
  (
    'MUG-002',
    'home',
    JSON_OBJECT('en', 'Glass Water Bottle', 'it', 'Bottiglia in Vetro'),
    JSON_OBJECT('en', 'Reusable bottle with leak-proof cap', 'it', 'Bottiglia riutilizzabile con tappo anti perdita'),
    JSON_OBJECT(
      'brand', JSON_OBJECT('en', 'EcoSip', 'it', 'EcoSip'),
      'made_in', JSON_OBJECT('en', 'Germany', 'it', 'Germania'),
      'color', JSON_OBJECT('en', 'transparent', 'it', 'trasparente'),
      'material', JSON_OBJECT('en', 'borosilicate glass', 'it', 'vetro borosilicato'),
      'height', JSON_OBJECT('en', '24.0 cm', 'it', '24.0 cm'),
      'width', JSON_OBJECT('en', '7.2 cm', 'it', '7.2 cm'),
      'depth', JSON_OBJECT('en', '7.2 cm', 'it', '7.2 cm'),
      'capacity', JSON_OBJECT('en', '500ml', 'it', '500ml'),
      'weight', JSON_OBJECT('en', '420g', 'it', '420g'),
      'closure_type', JSON_OBJECT('en', 'screw cap', 'it', 'tappo a vite'),
      'coating', JSON_OBJECT('en', 'anti-slip sleeve', 'it', 'rivestimento antiscivolo')
    ),
    22.00
  ),
  (
    'RUN-002',
    'footwear',
    JSON_OBJECT('en', 'Trail Running Shoes', 'it', 'Scarpe Trail Running'),
    JSON_OBJECT('en', 'Grip-focused shoes for rough terrain', 'it', 'Scarpe con grip per terreni sconnessi'),
    JSON_OBJECT(
      'brand', JSON_OBJECT('en', 'TerraMove', 'it', 'TerraMove'),
      'made_in', JSON_OBJECT('en', 'Indonesia', 'it', 'Indonesia'),
      'color', JSON_OBJECT('en', 'blue', 'it', 'blu'),
      'material', JSON_OBJECT('en', 'synthetic mesh', 'it', 'rete sintetica'),
      'size', JSON_OBJECT('en', '43', 'it', '43'),
      'height', JSON_OBJECT('en', '12.0 cm', 'it', '12.0 cm'),
      'width', JSON_OBJECT('en', '10.4 cm', 'it', '10.4 cm'),
      'depth', JSON_OBJECT('en', '30.1 cm', 'it', '30.1 cm'),
      'weight', JSON_OBJECT('en', '280g', 'it', '280g'),
      'closure_type', JSON_OBJECT('en', 'quick lace', 'it', 'allacciatura rapida'),
      'strap_type', JSON_OBJECT('en', 'ankle support', 'it', 'supporto caviglia'),
      'coating', JSON_OBJECT('en', 'mud guard', 'it', 'protezione fango')
    ),
    129.90
  );

INSERT INTO product_metadata_fields (product_type, field_key, label, value_type, is_required, sort_order)
VALUES
  ('electronics', 'brand', JSON_OBJECT('en', 'Brand', 'it', 'Marca'), 'text', 1, 10),
  ('electronics', 'made_in', JSON_OBJECT('en', 'Made In', 'it', 'Prodotto in'), 'text', 1, 20),
  ('electronics', 'color', JSON_OBJECT('en', 'Color', 'it', 'Colore'), 'text', 1, 30),
  ('electronics', 'material', JSON_OBJECT('en', 'Material', 'it', 'Materiale'), 'text', 1, 40),
  ('electronics', 'height', JSON_OBJECT('en', 'Height', 'it', 'Altezza'), 'dimension', 0, 50),
  ('electronics', 'width', JSON_OBJECT('en', 'Width', 'it', 'Larghezza'), 'dimension', 0, 60),
  ('electronics', 'depth', JSON_OBJECT('en', 'Depth', 'it', 'Profondita'), 'dimension', 0, 70),
  ('electronics', 'weight', JSON_OBJECT('en', 'Weight', 'it', 'Peso'), 'dimension', 0, 80),
  ('electronics', 'screen_size', JSON_OBJECT('en', 'Screen Size', 'it', 'Dimensione Schermo'), 'dimension', 0, 90),
  ('electronics', 'os', JSON_OBJECT('en', 'Operating System', 'it', 'Sistema Operativo'), 'text', 0, 100),
  ('electronics', 'cpu', JSON_OBJECT('en', 'CPU', 'it', 'CPU'), 'text', 0, 110),
  ('electronics', 'ram', JSON_OBJECT('en', 'RAM', 'it', 'RAM'), 'text', 0, 120),
  ('electronics', 'storage', JSON_OBJECT('en', 'Storage', 'it', 'Archiviazione'), 'text', 0, 130),
  ('electronics', 'coating', JSON_OBJECT('en', 'Coating', 'it', 'Rivestimento'), 'text', 0, 140),

  ('accessory', 'brand', JSON_OBJECT('en', 'Brand', 'it', 'Marca'), 'text', 1, 10),
  ('accessory', 'made_in', JSON_OBJECT('en', 'Made In', 'it', 'Prodotto in'), 'text', 1, 20),
  ('accessory', 'color', JSON_OBJECT('en', 'Color', 'it', 'Colore'), 'text', 1, 30),
  ('accessory', 'material', JSON_OBJECT('en', 'Material', 'it', 'Materiale'), 'text', 1, 40),
  ('accessory', 'height', JSON_OBJECT('en', 'Height', 'it', 'Altezza'), 'dimension', 0, 50),
  ('accessory', 'width', JSON_OBJECT('en', 'Width', 'it', 'Larghezza'), 'dimension', 0, 60),
  ('accessory', 'depth', JSON_OBJECT('en', 'Depth', 'it', 'Profondita'), 'dimension', 0, 70),
  ('accessory', 'layout', JSON_OBJECT('en', 'Layout', 'it', 'Layout'), 'text', 0, 80),
  ('accessory', 'switch_type', JSON_OBJECT('en', 'Switch Type', 'it', 'Tipo di Switch'), 'text', 0, 90),
  ('accessory', 'connectivity', JSON_OBJECT('en', 'Connectivity', 'it', 'Connettivita'), 'text', 0, 100),
  ('accessory', 'dpi', JSON_OBJECT('en', 'DPI', 'it', 'DPI'), 'number', 0, 110),
  ('accessory', 'weight', JSON_OBJECT('en', 'Weight', 'it', 'Peso'), 'dimension', 0, 120),
  ('accessory', 'coating', JSON_OBJECT('en', 'Coating', 'it', 'Rivestimento'), 'text', 0, 130),

  ('apparel', 'brand', JSON_OBJECT('en', 'Brand', 'it', 'Marca'), 'text', 1, 10),
  ('apparel', 'made_in', JSON_OBJECT('en', 'Made In', 'it', 'Prodotto in'), 'text', 1, 20),
  ('apparel', 'color', JSON_OBJECT('en', 'Color', 'it', 'Colore'), 'text', 1, 30),
  ('apparel', 'material', JSON_OBJECT('en', 'Material', 'it', 'Materiale'), 'text', 1, 40),
  ('apparel', 'size', JSON_OBJECT('en', 'Size', 'it', 'Taglia'), 'text', 1, 50),
  ('apparel', 'fit', JSON_OBJECT('en', 'Fit', 'it', 'Vestibilita'), 'text', 0, 60),
  ('apparel', 'height', JSON_OBJECT('en', 'Height', 'it', 'Altezza'), 'dimension', 0, 70),
  ('apparel', 'width', JSON_OBJECT('en', 'Width', 'it', 'Larghezza'), 'dimension', 0, 80),
  ('apparel', 'depth', JSON_OBJECT('en', 'Depth', 'it', 'Profondita'), 'dimension', 0, 90),
  ('apparel', 'closure_type', JSON_OBJECT('en', 'Closure Type', 'it', 'Tipo di Chiusura'), 'text', 0, 100),
  ('apparel', 'strap_type', JSON_OBJECT('en', 'Strap Type', 'it', 'Tipo di Spalline'), 'text', 0, 110),
  ('apparel', 'coating', JSON_OBJECT('en', 'Coating', 'it', 'Rivestimento'), 'text', 0, 120),

  ('home', 'brand', JSON_OBJECT('en', 'Brand', 'it', 'Marca'), 'text', 1, 10),
  ('home', 'made_in', JSON_OBJECT('en', 'Made In', 'it', 'Prodotto in'), 'text', 1, 20),
  ('home', 'color', JSON_OBJECT('en', 'Color', 'it', 'Colore'), 'text', 1, 30),
  ('home', 'material', JSON_OBJECT('en', 'Material', 'it', 'Materiale'), 'text', 1, 40),
  ('home', 'height', JSON_OBJECT('en', 'Height', 'it', 'Altezza'), 'dimension', 0, 50),
  ('home', 'width', JSON_OBJECT('en', 'Width', 'it', 'Larghezza'), 'dimension', 0, 60),
  ('home', 'depth', JSON_OBJECT('en', 'Depth', 'it', 'Profondita'), 'dimension', 0, 70),
  ('home', 'capacity', JSON_OBJECT('en', 'Capacity', 'it', 'Capacita'), 'dimension', 0, 80),
  ('home', 'weight', JSON_OBJECT('en', 'Weight', 'it', 'Peso'), 'dimension', 0, 90),
  ('home', 'closure_type', JSON_OBJECT('en', 'Closure Type', 'it', 'Tipo di Chiusura'), 'text', 0, 100),
  ('home', 'coating', JSON_OBJECT('en', 'Coating', 'it', 'Rivestimento'), 'text', 0, 110),

  ('footwear', 'brand', JSON_OBJECT('en', 'Brand', 'it', 'Marca'), 'text', 1, 10),
  ('footwear', 'made_in', JSON_OBJECT('en', 'Made In', 'it', 'Prodotto in'), 'text', 1, 20),
  ('footwear', 'color', JSON_OBJECT('en', 'Color', 'it', 'Colore'), 'text', 1, 30),
  ('footwear', 'material', JSON_OBJECT('en', 'Material', 'it', 'Materiale'), 'text', 1, 40),
  ('footwear', 'size', JSON_OBJECT('en', 'Size', 'it', 'Taglia'), 'text', 1, 50),
  ('footwear', 'height', JSON_OBJECT('en', 'Height', 'it', 'Altezza'), 'dimension', 0, 60),
  ('footwear', 'width', JSON_OBJECT('en', 'Width', 'it', 'Larghezza'), 'dimension', 0, 70),
  ('footwear', 'depth', JSON_OBJECT('en', 'Depth', 'it', 'Profondita'), 'dimension', 0, 80),
  ('footwear', 'weight', JSON_OBJECT('en', 'Weight', 'it', 'Peso'), 'dimension', 0, 90),
  ('footwear', 'closure_type', JSON_OBJECT('en', 'Closure Type', 'it', 'Tipo di Chiusura'), 'text', 0, 100),
  ('footwear', 'strap_type', JSON_OBJECT('en', 'Strap Type', 'it', 'Tipo di Spalline'), 'text', 0, 110),
  ('footwear', 'coating', JSON_OBJECT('en', 'Coating', 'it', 'Rivestimento'), 'text', 0, 120);
