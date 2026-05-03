<?php
/**
 * Testne skripte za news-app aplikacijo
 * Testiramo logiko neodvisno od baze podatkov (unit testi)
 * Avtor: 29913
 */

// ============================================================
// Enostavni testni "framework" (brez zunanjih odvisnosti)
// ============================================================
$passed = 0;
$failed = 0;
$errors = [];

function assert_equals($expected, $actual, string $testName): void {
    global $passed, $failed, $errors;
    if ($expected === $actual) {
        echo "[PASS] $testName\n";
        $passed++;
    } else {
        echo "[FAIL] $testName — pričakovano: " . var_export($expected, true) . ", dobljeno: " . var_export($actual, true) . "\n";
        $failed++;
        $errors[] = $testName;
    }
}

function assert_true(bool $condition, string $testName): void {
    global $passed, $failed, $errors;
    if ($condition) {
        echo "[PASS] $testName\n";
        $passed++;
    } else {
        echo "[FAIL] $testName — pogoj ni bil izpolnjen\n";
        $failed++;
        $errors[] = $testName;
    }
}

function assert_not_empty($value, string $testName): void {
    assert_true(!empty($value), $testName);
}

// ============================================================
// Pomožne funkcije, ki jih testiramo (izločene iz logike app)
// ============================================================

/**
 * Validira naslov članka — ne sme biti prazen in ne sme presegati 255 znakov
 */
function validateTitle(string $title): bool {
    $title = trim($title);
    return strlen($title) > 0 && strlen($title) <= 255;
}

/**
 * Sanitizira vhodni niz — odstrani nevarne znake za preprečevanje XSS
 */
function sanitizeInput(string $input): string {
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

/**
 * Simulira strukturo članka (kot bi ga vrnila baza)
 */
function createArticle(string $title, string $content, string $author): array {
    return [
        'title'   => $title,
        'content' => $content,
        'author'  => $author,
        'created' => date('Y-m-d H:i:s'),
    ];
}

/**
 * Preveri, ali je e-poštni naslov veljavne oblike
 */
function isValidEmail(string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Skrajša vsebino na določeno število znakov (za predogled)
 */
function truncateContent(string $content, int $maxLen = 100): string {
    if (strlen($content) <= $maxLen) return $content;
    return substr($content, 0, $maxLen) . '...';
}

/**
 * Preveri, ali URL vsebuje samo dovoljene znake (slug)
 */
function isValidSlug(string $slug): bool {
    return (bool) preg_match('/^[a-z0-9-]+$/', $slug);
}

// ============================================================
// TESTI
// ============================================================

echo "=== Začetek testiranja news-app ===\n\n";

// --- Testi za validateTitle ---
echo "-- validateTitle --\n";
assert_true(validateTitle("Normalen naslov"), "Normalen naslov je veljaven");
assert_true(validateTitle(str_repeat("a", 255)), "Naslov dolžine 255 je veljaven");
assert_true(!validateTitle(""), "Prazen naslov ni veljaven");
assert_true(!validateTitle("   "), "Niz s samo presledki ni veljaven");
assert_true(!validateTitle(str_repeat("a", 256)), "Naslov daljši od 255 ni veljaven");

// --- Testi za sanitizeInput ---
echo "\n-- sanitizeInput --\n";
assert_equals("alert(1)", sanitizeInput("<script>alert(1)</script>"), "XSS napad je sanitiziran");
assert_equals("Navaden tekst", sanitizeInput("Navaden tekst"), "Navaden tekst ostane nespremenjen");
assert_equals("Hello World", sanitizeInput("  Hello World  "), "Presledki so odstranjeni");
assert_equals("bold text", sanitizeInput("<b>bold text</b>"), "HTML oznake so odstranjene");

// --- Testi za createArticle ---
echo "\n-- createArticle --\n";
$article = createArticle("Test naslov", "Vsebina članka", "Simon");
assert_equals("Test naslov", $article['title'], "Naslov članka je pravilno nastavljen");
assert_equals("Vsebina članka", $article['content'], "Vsebina članka je pravilno nastavljena");
assert_equals("Simon", $article['author'], "Avtor članka je pravilno nastavljen");
assert_not_empty($article['created'], "Čas ustvarjanja je nastavljen");

// --- Testi za isValidEmail ---
echo "\n-- isValidEmail --\n";
assert_true(isValidEmail("simon@example.com"), "Veljaven e-poštni naslov");
assert_true(isValidEmail("user.name+tag@domain.co.uk"), "Kompleksen veljaven e-poštni naslov");
assert_true(!isValidEmail("neveljavenEmail"), "Neveljaven e-poštni naslov brez @");
assert_true(!isValidEmail("@domain.com"), "Neveljaven e-poštni naslov brez lokalnega dela");
assert_true(!isValidEmail(""), "Prazen niz ni veljaven e-poštni naslov");

// --- Testi za truncateContent ---
echo "\n-- truncateContent --\n";
assert_equals("Kratek tekst", truncateContent("Kratek tekst", 100), "Kratek tekst ni skrajšan");
$long = str_repeat("a", 150);
$result = truncateContent($long, 100);
assert_equals(103, strlen($result), "Skrajšan tekst ima pravilno dolžino (100 + '...')");
assert_true(str_ends_with($result, '...'), "Skrajšan tekst se konča z '...'");

// --- Testi za isValidSlug ---
echo "\n-- isValidSlug --\n";
assert_true(isValidSlug("moj-clanek-123"), "Veljaven slug");
assert_true(isValidSlug("novice"), "Enobessedni slug je veljaven");
assert_true(!isValidSlug("Veliki Znaki"), "Slug z velikimi črkami ni veljaven");
assert_true(!isValidSlug("clanek/pot"), "Slug s poševnico ni veljaven");
assert_true(!isValidSlug(""), "Prazen slug ni veljaven");

// ============================================================
// POVZETEK
// ============================================================
echo "\n=== Rezultat testiranja ===\n";
echo "Uspešnih: $passed\n";
echo "Neuspešnih: $failed\n";

if ($failed > 0) {
    echo "\nNeuspešni testi:\n";
    foreach ($errors as $e) {
        echo "  - $e\n";
    }
    exit(1); // Izhodni kod 1 pomeni napako — CI/CD pipeline bo zaznal neuspeh
}

echo "\nVsi testi so uspešno prestali!\n";
exit(0);
