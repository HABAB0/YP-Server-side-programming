<h2 class="page-title">Список должников</h2>

<div class="accommodations-actions">
    <a href="/debtors" class="btn btn-primary">Все должники</a>
    <a href="/accommodations" class="btn btn-secondary">Назад к жильцам</a>
</div>

<div class="accommodations-table-wrapper">
    <table class="table accommodations-table">
        <thead class="accommodations-table__tbody">
        <tr class="accommodations-table__row ">
            <th class="accommodations-table__header">Жилец</th>
            <th class="accommodations-table__header">Комната</th>
            <th class="accommodations-table__header">Период</th>
            <th class="accommodations-table__header">Сумма</th>
            <th class="accommodations-table__header">Срок оплаты</th>
            <th class="accommodations-table__header">Статус</th>
            <th class="accommodations-table__header">Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($debtors as $debtor): ?>
            <tr class="accommodations-table__row">
                <td class="accommodations-table__cell">
                    <?= $debtor->roomer->fio ?>
                </td>
                <td class="accommodations-table__cell">
                    №<?= $debtor->room->room_number ?>
                </td>
                <td class="accommodations-table__cell">
                    <?= $debtor->payment_period ?? '—' ?>
                </td>
                <td class="accommodations-table__cell">
                    <?= $debtor->payment_amount ?> ₽
                </td>
                <td class="accommodations-table__cell">
                    <?= $debtor->payment_due_date ?>
                </td>
                <td class="accommodations-table__cell">
                    <?= $debtor->payment_status ?>
                </td>
                <td class="accommodations-table__cell">
                    <?php if ($debtor->payment_status !== 'paid'): ?>
                        <a href="/debtors/mark-paid/<?= $debtor->id ?>" class="btn btn-sm btn-success">
                            Оплатить
                        </a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>