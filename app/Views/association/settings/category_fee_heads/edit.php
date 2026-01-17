<h3>Assign Fee Heads</h3>

<form method="post" action="/association/settings/category-fee-heads/update">
    <input type="hidden" name="category_id" value="<?= $categoryId ?>">

    <?php foreach ($fees as $fee): ?>
        <div class="form-check">
            <input class="form-check-input"
                   type="checkbox"
                   name="fee_heads[]"
                   value="<?= $fee['id'] ?>">
            <label class="form-check-label">
                <?= $fee['name'] ?> (<?= $fee['periodicity'] ?> – ₹<?= $fee['amount'] ?>)
            </label>
        </div>
    <?php endforeach; ?>

    <button class="btn btn-primary mt-3">Save Mapping</button>
</form>