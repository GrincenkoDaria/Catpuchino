<?php
include_once __DIR__ . '/db.php';

$errors = [];
$successName = '';
$showModal = false;

$amountValue = 20;
$firstNameValue = '';
$lastNameValue = '';
$cardNumberValue = '';
$expiryValue = '';
$cvvValue = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amountValue = isset($_POST['amount']) ? (int) $_POST['amount'] : 20;
    $firstNameValue = trim($_POST['firstName'] ?? '');
    $lastNameValue = trim($_POST['lastName'] ?? '');
    $cardNumberValue = trim($_POST['cardNumber'] ?? '');
    $expiryValue = trim($_POST['expiry'] ?? '');
    $cvvValue = trim($_POST['cvv'] ?? '');

    if ($amountValue < 5 || $amountValue > 100) {
        $errors[] = 'Donation amount must be between 5 and 100 €.';
    }

    if ($firstNameValue === '' || !preg_match('/^[a-zA-ZÀ-ž\s\-]{2,50}$/u', $firstNameValue)) {
        $errors[] = 'First name is not in the correct format.';
    }

    if ($lastNameValue === '' || !preg_match('/^[a-zA-ZÀ-ž\s\-]{2,50}$/u', $lastNameValue)) {
        $errors[] = 'Last name is not in the correct format.';
    }

    $cardDigits = preg_replace('/\D+/', '', $cardNumberValue);
    if (!preg_match('/^\d{16}$/', $cardDigits)) {
        $errors[] = 'Card number must contain exactly 16 digits.';
    }

    $expMonth = 0;
    $expYear = 0;

    if (!preg_match('/^(0[1-9]|1[0-2])\/(\d{2})$/', $expiryValue, $expiryMatches)) {
        $errors[] = 'Expiry must be in MM/YY format.';
    } else {
        $expMonth = (int) $expiryMatches[1];
        $expYear = (int) ('20' . $expiryMatches[2]);

        $currentMonth = (int) date('m');
        $currentYear = (int) date('Y');

        if ($expYear < $currentYear || ($expYear === $currentYear && $expMonth < $currentMonth)) {
            $errors[] = 'Card expiry date is in the past.';
        }
    }

    if (!preg_match('/^\d{3,4}$/', $cvvValue)) {
        $errors[] = 'CVV must contain 3 or 4 digits.';
    }

    if (empty($errors)) {
        $cardLast4 = substr($cardDigits, -4);

        $stmt = $conn->prepare("
            INSERT INTO donations (
                first_name,
                last_name,
                amount,
                card_last4,
                expiry_month,
                expiry_year
            ) VALUES (?, ?, ?, ?, ?, ?)
        ");

        if ($stmt) {
            $stmt->bind_param(
                'ssdsii',
                $firstNameValue,
                $lastNameValue,
                $amountValue,
                $cardLast4,
                $expMonth,
                $expYear
            );

            if ($stmt->execute()) {
                $successName = $firstNameValue;
                $showModal = true;

                $amountValue = 20;
                $firstNameValue = '';
                $lastNameValue = '';
                $cardNumberValue = '';
                $expiryValue = '';
                $cvvValue = '';
            } else {
                $errors[] = 'Failed to save donation.';
            }

            $stmt->close();
        } else {
            $errors[] = 'Database error.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'modules/parts/head.php'; ?>
    <style>
        .donate-main {
            background: var(--color7);
            padding: 3rem 0 4rem;
            min-height: calc(100vh - 140px);
        }

        .donate-section {
            max-width: 760px;
            margin: 0 auto;
        }

        .donate-heading {
            margin-bottom: 1.5rem;
            text-align: left;
        }

        .donate-heading h1 {
            margin: 0 0 0.6rem;
            font-size: clamp(2.2rem, 5vw, 3.4rem);
            line-height: 1;
            color: var(--color1);
        }

        .donate-heading p {
            margin: 0;
            font-size: 1.05rem;
            line-height: 1.6;
            color: var(--color2);
        }

        .donate-form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .donate-card {
            background: var(--color5);
            border-radius: 22px;
            padding: 1.4rem;
            box-shadow: 0 14px 34px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.06);
        }

        .donate-label {
            display: block;
            margin-bottom: 0.8rem;
            font-weight: 700;
            font-size: 0.98rem;
            color: var(--color1);
        }

        #donateRange {
            width: 100%;
            accent-color: var(--color3);
            cursor: pointer;
        }

        .donate-amount-display {
            margin: 1rem 0 0;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.6rem 1rem;
            border-radius: 999px;
            background: rgba(202, 143, 95, 0.16);
            color: var(--color3);
            font-size: 1.2rem;
            font-weight: 700;
        }

        .donate-field {
            display: flex;
            flex-direction: column;
            gap: 0.45rem;
            margin-bottom: 1rem;
        }

        .donate-field label {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--color1);
        }

        .donate-field input {
            width: 100%;
            height: 50px;
            padding: 0 1rem;
            border-radius: 14px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            background: #fff;
            font-size: 1rem;
            color: var(--color1);
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            box-sizing: border-box;
        }

        .donate-field input:focus {
            border-color: var(--color3);
            box-shadow: 0 0 0 4px rgba(202, 143, 95, 0.16);
        }

        .donate-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .donate-submit-btn {
            width: 100%;
            height: 52px;
            margin-top: 0.3rem;
            border: 0;
            border-radius: 999px;
            background: var(--color3);
            color: var(--color5);
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s ease, background 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 10px 20px rgba(202, 143, 95, 0.24);
        }

        .donate-submit-btn:hover {
            background: var(--color1);
            transform: translateY(-2px);
        }

        .donate-errors {
            background: #fff0f0;
            border: 1px solid #e6b3b3;
            color: #8a1f1f;
            border-radius: 16px;
            padding: 1rem 1.2rem;
            margin-bottom: 1rem;
        }

        .donate-errors p {
            margin: 0 0 0.4rem;
            font-weight: 700;
        }

        .donate-errors ul {
            margin: 0;
            padding-left: 1.1rem;
        }

        .donate-modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.42);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            z-index: 9999;
        }

        .donate-modal.is-open {
            display: flex;
        }

        .donate-modal-box {
            width: 100%;
            max-width: 480px;
            background: var(--color5);
            border-radius: 24px;
            padding: 2rem 1.5rem;
            text-align: center;
            box-shadow: 0 22px 44px rgba(0, 0, 0, 0.18);
        }

        .donate-modal-box h2 {
            margin: 0 0 1.25rem;
            color: var(--color1);
            line-height: 1.35;
            font-size: 1.8rem;
        }

        .donate-shop-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 160px;
            padding: 0.85rem 1.2rem;
            border-radius: 999px;
            background: var(--color3);
            color: var(--color5);
            text-decoration: none;
            font-weight: 700;
            transition: transform 0.2s ease, background 0.2s ease;
        }

        .donate-shop-btn:hover {
            background: var(--color1);
            transform: translateY(-1px);
        }

        @media (max-width: 600px) {
            .donate-main {
                padding: 2rem 0 3rem;
            }

            .donate-card {
                padding: 1.1rem;
                border-radius: 18px;
            }

            .donate-form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .donate-modal-box h2 {
                font-size: 1.45rem;
            }
        }
    </style>
</head>
<body>
    <?php include 'modules/parts/header.php'; ?>

    <main class="donate-main">
        <div class="page-container">
            <section class="donate-section">
                <div class="donate-heading">
                    <h1>Donate</h1>
                    <p>Support our café cats and help us care for them.</p>
                </div>

                <?php if (!empty($errors)): ?>
                    <div class="donate-errors">
                        <p>Please fix these errors:</p>
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form class="donate-form" id="donateForm" method="post" novalidate>
                    <div class="donate-card">
                        <label for="donateRange" class="donate-label">Donation amount</label>
                        <input
                            type="range"
                            id="donateRange"
                            name="amount"
                            min="5"
                            max="100"
                            value="<?php echo htmlspecialchars((string) $amountValue); ?>"
                            step="1"
                        >
                        <p class="donate-amount-display"><span id="donateAmount"><?php echo htmlspecialchars((string) $amountValue); ?></span> €</p>
                    </div>

                    <div class="donate-card">
                        <div class="donate-field">
                            <label for="firstName">First name</label>
                            <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($firstNameValue); ?>" required>
                        </div>

                        <div class="donate-field">
                            <label for="lastName">Last name</label>
                            <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($lastNameValue); ?>" required>
                        </div>

                        <div class="donate-field">
                            <label for="cardNumber">Card number</label>
                            <input type="text" id="cardNumber" name="cardNumber" maxlength="19" placeholder="1234 5678 9012 3456" value="<?php echo htmlspecialchars($cardNumberValue); ?>" required>
                        </div>

                        <div class="donate-form-row">
                            <div class="donate-field">
                                <label for="expiry">Expiry</label>
                                <input type="text" id="expiry" name="expiry" maxlength="5" placeholder="MM/YY" value="<?php echo htmlspecialchars($expiryValue); ?>" required>
                            </div>

                            <div class="donate-field">
                                <label for="cvv">CVV</label>
                                <input type="text" id="cvv" name="cvv" maxlength="4" placeholder="123" value="<?php echo htmlspecialchars($cvvValue); ?>" required>
                            </div>
                        </div>

                        <button type="submit" class="donate-submit-btn">Send</button>
                    </div>
                </form>
            </section>
        </div>
    </main>

    <div class="donate-modal<?php echo $showModal ? ' is-open' : ''; ?>" id="donateModal" aria-hidden="<?php echo $showModal ? 'false' : 'true'; ?>">
        <div class="donate-modal-box">
            <h2>Thank you for your donate, <span id="donorName"><?php echo htmlspecialchars($successName); ?></span></h2>
            <a href="index.php" class="donate-shop-btn">Go back</a>
        </div>
    </div>

    <?php include 'modules/parts/footer.php'; ?>

    <script>
        const donateRange = document.getElementById('donateRange');
        const donateAmount = document.getElementById('donateAmount');
        const donateModal = document.getElementById('donateModal');
        const expiryInput = document.getElementById('expiry');
        const cardNumberInput = document.getElementById('cardNumber');
        const cvvInput = document.getElementById('cvv');

        donateRange.addEventListener('input', function () {
            donateAmount.textContent = donateRange.value;
        });

        expiryInput.addEventListener('input', function () {
            let value = expiryInput.value.replace(/\D/g, '');

            if (value.length > 4) {
                value = value.substring(0, 4);
            }

            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2);
            }

            expiryInput.value = value;
        });

        cardNumberInput.addEventListener('input', function () {
            let value = cardNumberInput.value.replace(/\D/g, '');

            if (value.length > 16) {
                value = value.substring(0, 16);
            }

            value = value.replace(/(.{4})/g, '$1 ').trim();
            cardNumberInput.value = value;
        });

        cvvInput.addEventListener('input', function () {
            cvvInput.value = cvvInput.value.replace(/\D/g, '').substring(0, 4);
        });

        donateModal.addEventListener('click', function (e) {
            if (e.target === donateModal) {
                donateModal.classList.remove('is-open');
                donateModal.setAttribute('aria-hidden', 'true');
            }
        });
    </script>
</body>
</html>