/**
 * Разворачивает ошибку $fetch (422 Unprocessable / любой 4xx/5xx) в
 * человекочитаемую строку для отображения в форме.
 *
 * Laravel при ошибке валидации возвращает:
 *   { message: "...", errors: { field: ["msg1", ...], ... } }
 * При других ошибках — просто { message: "..." }
 */
export function useFormError() {
  function parseError(e: unknown): string {
    const data = (e as any)?.data ?? (e as any)?.response?._data

    if (!data) return (e as any)?.message ?? 'Неизвестная ошибка'

    // 422: есть объект errors — выводим все сообщения списком
    if (data.errors && typeof data.errors === 'object') {
      const messages: string[] = Object.values(data.errors).flat() as string[]
      if (messages.length) return messages.join('\n')
    }

    return data.message ?? 'Неизвестная ошибка'
  }

  return { parseError }
}
