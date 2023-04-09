function activate (table) {
    let lastSort = null
    table.querySelectorAll('th.sort').forEach(th => {
        if (th.dataset.sort) {
            const key = th.dataset.sort
            const type = th.dataset.type || 'string'
            let asc = type === 'string'
            if ('asc' in th.dataset) asc = true
            else if ('des' in th.dataset) asc = false

            let reverse = asc
            th.addEventListener('click', () => {
                // if clicked twice in a row,
                sort(table, { key, asc: lastSort === key ? reverse : asc, type })
                reverse = lastSort === key ? !reverse : !asc
                lastSort = th.dataset.sort
            })
        }
    })
}

function sort (table, { key, asc, type }) {

    const rows = table.rows
    const tbody = table.querySelector('tbody')

    const change = (el, co) => {
        let a = el.dataset[key]
        let b = co.dataset[key]

        if (type === 'number') {
            a = Number(a)
            b = Number(b)

            if (!isNaN(a) && isNaN(b)) return true
            else if (isNaN(a) && !isNaN(b)) return false

        } else if (type === 'bool') {
            a = a !== undefined
            b = b !== undefined

        } else {
            if (a !== undefined && b === undefined) return true
            if (b !== undefined && a === undefined) return false
            if (a) a = a.toLowerCase()
            if (b) b = b.toLowerCase()
        }

        return asc ? a < b : a > b
    }

    // Insertion sort, start at index 1 since 0 is the headers

    for (let i = 2; i < rows.length; i++) {
        let j = i
        while (j > 1 && change(rows[i], rows[j - 1])) j--
        if (j !== i) {
            tbody.insertBefore(rows[i], rows[j])
        }
    }
}

export { activate }
