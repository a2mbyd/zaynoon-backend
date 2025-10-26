<h1>🧱 Zaynoon Backend – Project Rules</h1>

<p><strong>Repository:</strong> <code>zaynoon-backend</code><br>
<strong>Architecture:</strong> Modular Monolith (Laravel + Inertia.js)<br>
<strong>Environment:</strong> Local full-stack integration with <code>zaynoon-frontend</code></p>

<hr>

<h2>🚀 Tech Overview</h2>

<h3>🧩 Core Stack</h3>
<table>
<tr><th>Component</th><th>Technology</th></tr>
<tr><td>Framework</td><td>Laravel 12 (PHP 8.3+)</td></tr>
<tr><td>Frontend Bridge</td><td>Inertia.js</td></tr>
<tr><td>Build Tool</td><td>Vite</td></tr>
<tr><td>Database</td><td>SQLite / MySQL</td></tr>
<tr><td>Formatter</td><td>Laravel Pint</td></tr>
<tr><td>Testing</td><td>Pest (planned)</td></tr>
</table>

<h3>⚙️ Local Setup</h3>
<ul>
<li><strong>Backend:</strong> <code>http://localhost:8000</code></li>
<li><strong>Frontend (Vite dev server):</strong> <code>http://localhost:5173</code></li>
</ul>

<hr>

<h2>🧩 Architecture: Modular Monolith</h2>

<p>Each domain feature lives inside its own folder under <code>app/Modules/</code>.<br>
Every module is <strong>self-contained</strong> — it owns its:</p>

<ul>
<li>Controllers</li>
<li>Models</li>
<li>Routes</li>
<li>Services</li>
<li>Database migrations/seeders</li>
<li>Service provider</li>
</ul>

<p>Shared logic (helpers, traits, global utilities) lives in <code>Modules/Shared/</code>.</p>

<h3>📁 Actual Folder Structure</h3>

<pre>
app/
├── Http/
│   └── Controllers/
│       └── Controller.php
│
├── Models/
│
├── Modules/
│   ├── Users/
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   ├── Middleware/
│   │   │   └── Requests/
│   │   ├── Models/
│   │   │   ├── User.php
│   │   │   ├── Role.php
│   │   │   └── Address.php
│   │   ├── Services/
│   │   ├── Providers/
│   │   │   └── UsersServiceProvider.php
│   │   ├── routes/
│   │   │   └── web.php
│   │   └── database/
│   │       ├── migrations/
│   │       └── seeders/
│   │
│   ├── Carts/
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   ├── Middleware/
│   │   │   └── Requests/
│   │   ├── Models/
│   │   │   ├── Cart.php
│   │   │   └── CartItem.php
│   │   ├── Services/
│   │   ├── Providers/
│   │   │   └── CartsServiceProvider.php
│   │   ├── routes/
│   │   │   └── web.php
│   │   └── database/
│   │       ├── migrations/
│   │       └── seeders/
│   │
│   ├── Catalog/
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   ├── Middleware/
│   │   │   └── Requests/
│   │   ├── Models/
│   │   │   ├── Product.php
│   │   │   ├── Category.php
│   │   │   └── Tag.php
│   │   ├── Services/
│   │   ├── Providers/
│   │   │   └── CatalogServiceProvider.php
│   │   ├── routes/
│   │   │   └── web.php
│   │   └── database/
│   │       ├── migrations/
│   │       └── seeders/
│   │
│   │
│   ├── OtherModules/ ... 
│   │
│   │
│   └── Shared/
│       ├── Http/
│       │   ├── Controllers/
│       │   ├── Middleware/
│       │   └── Requests/
│       ├── Models/
│       ├── Services/
│       ├── Providers/
│       │   └── SharedServiceProvider.php
│       ├── routes/
│       │   └── web.php
│       └── database/
│           ├── migrations/
│           └── seeders/
│
└── Providers/
    └── AppServiceProvider.php
</pre>

<hr>

<h2>🧱 Module Rules</h2>

<h3>🧩 1. Module Provider</h3>
<ul>
<li>Each module must contain a <code>*ServiceProvider.php</code>.</li>
<li>Example: <code>UsersServiceProvider</code>, <code>CartsServiceProvider</code>, etc.</li>
<li>Providers are auto-loaded by <code>ModulesServiceProvider</code> using:</li>
</ul>

<pre><code class="language-php">
foreach (glob(app_path('Modules/*/Providers/*ServiceProvider.php')) as $provider) {
    $class = 'App\\Modules\\' . basename(dirname(dirname($provider))) . '\\Providers\\' . basename($provider, '.php');
    $this->app->register($class);
}
</code></pre>

<h3>🧩 2. Module Routing</h3>
<ul>
<li>Every module includes its own <code>routes/web.php</code>.</li>
<li>No global prefixing or naming — keep routes simple and isolated.</li>
</ul>

<pre><code class="language-php">
use App\Modules\Carts\Http\Controllers\CartController;
Route::get('/cart', [CartController::class, 'index']);
</code></pre>

<p>Use <code>/routes/web.php</code> (root) only for homepage and global pages.</p>

<h3>🧩 3. Controllers</h3>
<ul>
<li>Controllers handle only request/response logic.</li>
<li>Use Inertia for frontend rendering:</li>
</ul>

<pre><code class="language-php">
return Inertia::render('Cart/Index', ['cart' => $cart]);
</code></pre>

<h3>🧩 4. Services</h3>
<p>Each module defines reusable business logic in <code>Services/</code>.</p>

<pre><code class="language-php">
class CartService {
    public function calculateTotal(Cart $cart): float { ... }
}
</code></pre>

<h3>🧩 5. Models</h3>
<ul>
<li>Models live inside their corresponding module folder.</li>
<li><code>app/Models</code> remains empty unless a model is global.</li>
</ul>

<h3>🧩 6. Middleware</h3>
<ul>
<li>Global middleware → <code>app/Http/Middleware</code></li>
<li>Module-specific middleware → <code>Modules/&lt;Module&gt;/Http/Middleware</code></li>
</ul>

<hr>

<h2>⚙️ Global Routes</h2>

<p>Located in <code>/routes/web.php</code><br>
Used for global pages only — homepage, static, or fallback routes.</p>

<pre><code class="language-php">
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => Inertia::render('Home'));
Route::get('/about', fn() => Inertia::render('About'));
</code></pre>

<hr>

<h2>🧾 Environment Configuration</h2>

<h3>.env Example</h3>
<pre><code class="language-env">
APP_NAME=Zaynoon
APP_ENV=local
APP_URL=http://localhost:8000
FRONTEND_URL=http://localhost:5173

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

VITE_DEV_SERVER_URL=http://localhost:5173
SESSION_DOMAIN=localhost
</code></pre>

<ul>
<li><strong>Frontend (Vite):</strong> port 5173</li>
<li><strong>Backend (Laravel):</strong> port 8000</li>
<li><strong>Sanctum & Fortify:</strong> added later</li>
</ul>

<hr>

<h2>🧰 Code Quality & Conventions</h2>

<h3>Formatting</h3>
<p>Run Laravel Pint for PSR-12 formatting:</p>
<pre><code>./vendor/bin/pint</code></pre>

<h3>Naming</h3>
<table>
<tr><th>Type</th><th>Convention</th><th>Example</th></tr>
<tr><td>Controller</td><td>PascalCase + Controller</td><td>UserController</td></tr>
<tr><td>Service</td><td>PascalCase + Service</td><td>CartService</td></tr>
<tr><td>Request</td><td>PascalCase + Request</td><td>CreateUserRequest</td></tr>
<tr><td>Model</td><td>Singular PascalCase</td><td>User</td></tr>
</table>

<h3>Typing</h3>
<pre><code class="language-php">
public function index(Request $request): Response
</code></pre>

<hr>

<h2>🧪 Testing (Future)</h2>

<p>Use <strong>Pest</strong> for expressive tests.</p>
<ul>
<li>Feature tests → <code>tests/Feature/Modules/...</code></li>
<li>Unit tests → <code>tests/Unit/Modules/...</code></li>
</ul>

<pre><code class="language-php">
it('creates a new user', function () {
    $response = $this->post('/users', ['name' => 'Test']);
    $response->assertStatus(302);
});
</code></pre>

<hr>

<h2>🚀 Deployment (could be changed later)</h2>

<h3>Local Build Flow</h3>
<ol>
<li>Build frontend: <code>npm run build</code></li>
<li>Copy frontend build output into backend:
<pre><code>cp -r ../zaynoon-frontend/dist/* ./public/build/</code></pre></li>
<li>Deploy backend normally.</li>
</ol>

<h3>CI/CD Snippet</h3>
<pre><code class="language-yaml">
- name: Copy frontend build
  run: cp -r ../zaynoon-frontend/dist/* ./public/build/
</code></pre>

<hr>

<h2>🧭 Maintenance & Documentation</h2>

<ul>
<li>Each module must include a small <code>README.md</code> describing:</li>
  <ul>
    <li>Purpose</li>
    <li>Routes</li>
    <li>Services</li>
  </ul>
<li>Root <code>README.md</code> must describe:</li>
  <ul>
    <li>Environment setup</li>
    <li>Frontend repository link</li>
    <li>Module registration logic</li>
  </ul>
</ul>

<hr>

<h2>✅ Developer Checklist</h2>

<ul>
<li>✔️ Modular structure under <code>app/Modules</code></li>
<li>✔️ Each module has controller, models, routes, provider</li>
<li>✔️ Providers auto-registered</li>
<li>✔️ Global routes in <code>/routes/web.php</code></li>
<li>✔️ PSR-12 formatting with Pint</li>
<li>✔️ Inertia used for rendering</li>
<li>✔️ .env links backend ↔ frontend</li>
<li>⬜ Add Pest tests later</li>
<li>⬜ Add Sanctum/Fortify later</li>
</ul>

<hr>

<p><strong>Version:</strong> 1.1<br>
<strong>Last Updated:</strong> October 2025<br>
<strong>Maintainer:</strong> Mutaz Younes</p>
